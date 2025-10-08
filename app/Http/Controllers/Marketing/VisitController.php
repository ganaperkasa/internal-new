<?php

namespace App\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Instansi;
use App\Models\Kunjungan;
use App\Models\Kontak;
use Auth;
use DB;


class VisitController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:6');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function contact(Request $request)
    {

        if($request->ajax())
        {
            $query = DB::select("select k.*, i.name as instansi from mkt_kontak k
            inner join m_instansi i on i.id = k.instansi_id");
            $datatables = DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $html = '';
                    $html .=
                        '<a href="'.url('marketing/visit/'.$data->id.'/edit').'" class="mb-2 mr-2 btn btn-primary" >Ubah</a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'delete', 'route' => [ 'visit.destroy', $data->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="mb-2 mr-2 btn btn-danger dt-btn" data-swa-text="Hapus Kontak '.$data->nama.'?" >Hapus</button>'
                        .\Form::close();
                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }

        return view('marketing.visit.contact');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = DB::table('mkt_kunjungan as k')
                    ->select(
                        'k.id',
                        'k.tanggal',
                        'k.jam1',
                        'k.jam2',
                        'k.keterangan',
                        'k.instansi_id',
                        'u.name as created',
                        'i.name as instansi'
                    )
                    ->join('m_instansi as i', 'i.id', '=', 'k.instansi_id')
                    ->join('users as u', 'u.id', '=', 'k.created_by')
                    ->where('k.status', 1)
                    ->orderBy('k.tanggal', 'desc');

                return DataTables::of($query)
                    ->filterColumn('instansi', function($query, $keyword) {
                        $query->whereRaw("i.name LIKE ?", ["%{$keyword}%"]);
                    })
                    ->filterColumn('tanggal', function($query, $keyword) {
                        $query->whereRaw("k.tanggal LIKE ?", ["%{$keyword}%"]);
                    })
                    ->filterColumn('jam1', function($query, $keyword) {
                        $query->whereRaw("k.jam1 LIKE ?", ["%{$keyword}%"]);
                    })
                    ->filterColumn('jam2', function($query, $keyword) {
                        $query->whereRaw("k.jam2 LIKE ?", ["%{$keyword}%"]);
                    })
                    ->filterColumn('keterangan', function($query, $keyword) {
                        $query->whereRaw("k.keterangan LIKE ?", ["%{$keyword}%"]);
                    })
                    ->filterColumn('created', function($query, $keyword) {
                        $query->whereRaw("u.name LIKE ?", ["%{$keyword}%"]);
                    })
                    ->addColumn('action', function($data){
                        $editUrl = url('marketing/visit/'.$data->id.'/edit');
                        $html = '<a href="'.$editUrl.'" class="mb-2 mr-2 btn btn-primary btn-sm">Ubah</a>';

                        $html .= '<form method="POST" action="'.route('visit.destroy', $data->id).'" style="display:inline-block;">';
                        $html .= csrf_field();
                        $html .= method_field('DELETE');
                        $html .= '<button type="submit" class="mb-2 mr-2 btn btn-danger btn-sm dt-btn" data-swa-text="Hapus Kunjungan '.$data->keterangan.'?">Hapus</button>';
                        $html .= '</form>';

                        return $html;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return view('marketing.visit.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['instansi'] = Instansi::where('status',1)->orderBy('name')->pluck('name','id');
        return view('marketing.visit.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'instansi_id' => 'required|max:200',
            'keterangan' => 'required',
            'tanggal' => 'required',
            'jam1' => 'required',
            'jam2' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $data = new Kunjungan();
            $data->instansi_id = $request->instansi_id;
            $data->jam1 = $request->jam1;
            $data->jam2 = $request->jam2;
            $data->tanggal = date('Y-m-d', strtotime($request->tanggal));
            $data->keterangan = $request->keterangan;
            $data->created_by = \Auth::user()->id;
            $data->updated_by = \Auth::user()->id;
            $data->save();

            if($data->name != null){
                $dataKontak = new Kontak();
                $dataKontak->instansi_id = $request->instansi_id;
                $dataKontak->nama = $request->nama;
                $dataKontak->jabatan = $request->jabatan;
                $dataKontak->email = $request->email_pelanggan;
                $dataKontak->telp_1 = $request->telp_1;
                $dataKontak->telp_2 = $request->telp_2;
                $dataKontak->save();
            }
            DB::commit();

            return redirect('marketing/visit')->with('success', 'Data berhasil ditambah');
        }
        catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('danger', 'Data gagal ditambah');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['data_edit'] = Kunjungan::where('id',$id)->first();
        $data['instansi'] = Instansi::where('status',1)->orderBy('name')->pluck('name','id');
        return view('marketing.visit.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'instansi_id' => 'required|max:200',
            'keterangan' => 'required',
            'tanggal' => 'required',
            'jam1' => 'required',
            'jam2' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $data = Kunjungan::findOrFail($id);
            $data->instansi_id = $request->instansi_id;
            $data->jam1 = $request->jam1;
            $data->jam2 = $request->jam2;
            $data->tanggal = date('Y-m-d', strtotime($request->tanggal));
            $data->keterangan = $request->keterangan;
            $data->created_by = \Auth::user()->id;
            $data->updated_by = \Auth::user()->id;
            $data->save();

            DB::commit();

            return redirect('marketing/visit')->with('success', 'Data berhasil dirubah');
        }
        catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('danger', 'Data gagal dirubah');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      DB::beginTransaction();
      try
      {
          $data = Kunjungan::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('marketing/visit')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


}
