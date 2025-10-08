<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Barang;
use App\Models\Aset;
use App\Models\Setting;
use App\User;
use Auth;
use DB,DataTables;
use PDO;

class AsetController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:5');
    }

    public function index(Request $request)
    {

        if($request->ajax())
        {
            $query = DB::select("select s.*, u.name as created, i.name as barang,mi.name as instansi from adm_aset s
                                left join m_barang i on i.id = s.barang_id
                                left join users u on u.id = s.created_by
                                left join m_instansi mi on mi.id = s.instansi_id
                                where s.status = 1 ");
            $datatables = DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $html = '';
                    $html .=
                        '<a href="'.url('admin/aset/'.$data->id.'/edit').'" class="mb-2 mr-2 btn btn-primary" >Ubah</a>'.
                        '<a href="'.url('admin/aset/'.$data->id.'').'" class="mb-2 mr-2 btn btn-success" >Detail</a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'delete', 'route' => [ 'aset.destroy', $data->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="mb-2 mr-2 btn btn-danger dt-btn" data-swa-text="Hapus Aset '.$data->number.'?" >Hapus</button>'
                        .\Form::close();
                    return $html;
                })
                ->editColumn('kondisi',function($data){
                    return $data->kondisi.". ".$data->instansi;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
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

        $this->validate($request, [
            'barang_id' => 'required',
            'number' => 'required',
            'spesifikasi' => 'required',
            'name' => 'required',
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
        $this->validate($request, [
            'barang_id' => 'required',
            'spesifikasi' => 'required',
            'name' => 'required',
            
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
