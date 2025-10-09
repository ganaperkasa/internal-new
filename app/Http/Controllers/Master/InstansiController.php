<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Type;
use App\Models\Kontak;
use Auth;


class InstansiController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:5,6');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax())
        {
            
            $query = DB::table('m_instansi as i')->where ('i.status', 1);
            $datatables = DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $editUrl = url('master/instansi/'.$data->id.'/edit');
                    $delete = route('instansi.destroy', $data->id);
                    $html =

                        '<a href="'.$editUrl.'" class="mb-2 mr-2 btn btn-primary" >Ubah</a>
                        <form action="'.$delete.'" method="POST" style="display:inline-block;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="mb-2 mr-2 btn btn-danger dt-btn"
                                data-swa-text="Hapus Instansi '.$data->name.'?">
                                Hapus
                            </button>
                        </form>';
                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('master.instansi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.instansi.create');
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
            'name' => 'required|max:200',
        ]);
        DB::beginTransaction();
        try
        {
            $data = new Instansi();
            $data->name = $request->name;
            $data->type = $request->type;
            $data->email = $request->email;
            $data->telp = $request->telp;
            $data->fax = $request->fax;
            $data->address = $request->address;
            $data->website = $request->website;
            $data->save();

            if($data->name != null){
                $dataKontak = new Kontak();
                $dataKontak->instansi_id = $data->id;
                $dataKontak->nama = $request->nama;
                $dataKontak->jabatan = $request->jabatan;
                $dataKontak->email = $request->email_pelanggan;
                $dataKontak->telp_1 = $request->telp_1;
                $dataKontak->telp_2 = $request->telp_2;
                $dataKontak->save();
            }
            DB::commit();

            return redirect('master/instansi')->with('success', 'Data berhasil ditambah');
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

        $data['data_edit'] = Instansi::where('id',$id)->first();
        return view('master.instansi.edit', $data);
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
            'name' => 'required|max:200',
        ]);
        DB::beginTransaction();
        try
        {
            $data = Instansi::findOrFail($id);
            $data->name = $request->name;
            $data->type = $request->type;
            $data->email = $request->email;
            $data->telp = $request->telp;
            $data->fax = $request->fax;
            $data->address = $request->address;
            $data->website = $request->website;
            $data->save();

            DB::commit();

            return redirect('master/instansi')->with('success', 'Data berhasil dirubah');
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
          $data = Instansi::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('master/instansi')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


}
