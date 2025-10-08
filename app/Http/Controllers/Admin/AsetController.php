<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Instansi;
use App\Models\Barang;
use App\Models\Aset;
use App\Models\Setting;
use App\Models\User;
use DB,DataTables;
use Carbon\Carbon;

use PDO;

class AsetController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    // public function __construct()
    // {
    //    $this->middleware('auth');
    //     $this->middleware('role:5,6');
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Test koneksi database dulu
                $count = DB::table('adm_aset')->where('status', 1)->count();
                \Log::info('Total aset: ' . $count);

                $data = DB::table('adm_aset as s')
                    ->select(
                        's.id',
                        's.number',
                        's.name',
                        's.spesifikasi',
                        's.kondisi',
                        'u.name as created',
                        'i.name as barang',
                        'mi.name as instansi'
                    )
                    ->leftJoin('m_barang as i', 'i.id', '=', 's.barang_id')
                    ->leftJoin('users as u', 'u.id', '=', 's.created_by')
                    ->leftJoin('m_instansi as mi', 'mi.id', '=', 's.instansi_id')
                    ->where('s.status', 1);

                return DataTables::of($data)
                    ->addColumn('action', function ($data) {
                        $editUrl = url('admin/aset/'.$data->id.'/edit');
                        $detailUrl = url('admin/aset/'.$data->id);

                        $html  = '<a href="'.$editUrl.'" class="mb-2 mr-2 btn btn-primary">Ubah</a>';
                        $html .= '<a href="'.$detailUrl.'" class="mb-2 mr-2 btn btn-success">Detail</a>';
                        $html .= '<form method="POST" action="'.route('aset.destroy', $data->id).'" style="display:inline-block;">';
                        $html .= csrf_field();
                        $html .= method_field('DELETE');
                        $html .= '<button type="submit" class="mb-2 mr-2 btn btn-danger dt-btn" data-swa-text="Hapus Aset '.$data->number.'?">Hapus</button>';
                        $html .= '</form>';
                        return $html;
                    })
                    ->editColumn('kondisi', function ($data) {
                        return ($data->kondisi ?? '') . " - " . ($data->instansi ?? '');
                    })
                    ->rawColumns(['action'])
                    ->make(true);

            } catch (\Exception $e) {
                \Log::error('DataTables Error: ' . $e->getMessage());
                \Log::error($e->getTraceAsString());

                return response()->json([
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ], 500);
            }
        }

        return view('admin.aset.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['barang'] = Barang::where('status',1)->pluck('name','id');
        $data['instansi'] = Instansi::where('status',1)->orderBy('name')->pluck('name','id');
        return view('admin.aset.create',$data);
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
            'barang_id'   => 'required',
            'number'      => 'required',
            'spesifikasi' => 'required',
            'name'        => 'required',
        ]);
        DB::beginTransaction();
        try
        {

            $data = new Aset();
            $data->number = $request->number;
            $data->name = $request->name;
            $data->barang_id = $request->barang_id;
            $data->spesifikasi = $request->spesifikasi;
            $data->keterangan = $request->keterangan;
            $data->kondisi = $request->kondisi;

            if($request->kondisi == "Pinjam/Sewa"){
                $data->instansi_id = $request->instansi_id;
            }else{
                $data->instansi_id = null;
            }
            if($request->hasFile('document')){
                $req = $request->file('document');
                $file = rand().'.'.$req->getClientOriginalExtension();
                $req->move(public_path('uploads/aset/'),$file);
                $data->document = $file;
            }

            $data->created_by = \Auth::user()->id;
            $data->updated_by = \Auth::user()->id;
            $data->save();

            DB::commit();

            return redirect('admin/aset/'.$data->id)->with('success', 'Data berhasil ditambah');
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

        $data['data_edit'] = Aset::where('id',$id)->first();

        $data['instansi'] = Instansi::where('id',$data['data_edit']->instansi_id)->first();

        $data['barang'] = Barang::findOrFail($data['data_edit']->barang_id);
        $data['user'] = User::findOrFail($data['data_edit']->created_by);

        return view('admin.aset.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['data_edit'] = Aset::where('id',$id)->first();
        $data['instansi'] = Instansi::where('status',1)->orderBy('name')->pluck('name','id');
        $data['barang'] = Barang::where('status',1)->pluck('name','id');
        return view('admin.aset.edit', $data);
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
        $request->validate([
            'barang_id'   => 'required',
            'number'      => 'nullable',
            'spesifikasi' => 'required',
            'name'        => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $data = Aset::findOrFail($id);
            $data->name = $request->name;
            $data->barang_id = $request->barang_id;
            $data->spesifikasi = $request->spesifikasi;
            $data->keterangan = $request->keterangan;
            $data->kondisi = $request->kondisi;

            if($request->kondisi == "Pinjam/Sewa"){
                $data->instansi_id = $request->instansi_id;
            }else{
                $data->instansi_id = null;
            }
            if($request->hasFile('document')){
                $req = $request->file('document');
                $file = rand().'.'.$req->getClientOriginalExtension();
                $req->move(public_path('uploads/aset/'),$file);
                $data->document = $file;
            }

            $data->updated_by = \Auth::user()->id;
            $data->save();

            DB::commit();

            return redirect('admin/aset')->with('success', 'Data berhasil dirubah');
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
          $data = Aset::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('admin/aset')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


}
