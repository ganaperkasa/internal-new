<?php

namespace App\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Kunjungan;
use App\Models\Kontak;
use Auth;
use DB,DataTables;

class ContactController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:6');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        
        if($request->ajax())
        {
            $query = DB::select("select k.*, i.name as instansi from mkt_kontak k 
            inner join m_instansi i on i.id = k.instansi_id where k.status = 1");
            $datatables = DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $html = '';
                    $html .=
                        '<a href="'.url('marketing/contact/'.$data->id.'/edit').'" class="mb-2 mr-2 btn btn-primary" >Ubah</a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'delete', 'route' => [ 'contact.destroy', $data->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="mb-2 mr-2 btn btn-danger dt-btn" data-swa-text="Hapus Kontak '.$data->nama.'?" >Hapus</button>'
                        .\Form::close();
                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        
        return view('marketing.contact.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['instansi'] = Instansi::where('status',1)->orderBy('name')->pluck('name','id');
        return view('marketing.contact.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'instansi_id' => 'required|max:200',
            'nama' => 'required',
            'telp_1' => 'required',
            
        ]);
        DB::beginTransaction();
        try
        {
            
            
            $dataKontak = new Kontak();
            $dataKontak->instansi_id = $request->instansi_id;
            $dataKontak->nama = $request->nama;
            $dataKontak->jabatan = $request->jabatan;
            $dataKontak->email = $request->email;
            $dataKontak->telp_1 = $request->telp_1;
            $dataKontak->telp_2 = $request->telp_2;
            $dataKontak->created_by = \Auth::user()->id;
            $dataKontak->updated_by = \Auth::user()->id;
            $dataKontak->save();
        
            DB::commit();

            return redirect('marketing/contact')->with('success', 'Data berhasil ditambah');
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

        $data['data_edit'] = Kontak::where('id',$id)->first();
        $data['instansi'] = Instansi::where('status',1)->orderBy('name')->pluck('name','id');
        return view('marketing.contact.edit', $data);
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
            'nama' => 'required',
            'telp_1' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $data = Kontak::findOrFail($id);
            $data->instansi_id = $request->instansi_id;
            $data->nama = $request->nama;
            $data->jabatan = $request->jabatan;
            $data->email = $request->email;
            $data->telp_1 = $request->telp_1;
            $data->telp_2 = $request->telp_2;
            $data->save();

            DB::commit();

            return redirect('marketing/contact')->with('success', 'Data berhasil dirubah');
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
          $data = Kontak::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('marketing/contact')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


}
