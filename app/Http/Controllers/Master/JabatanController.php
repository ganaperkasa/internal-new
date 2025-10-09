<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Type;
use App\Models\Kontak;
use Auth;


class JabatanController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:5');
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
            // $query = DB::select("select i.* from m_jabatan i where i.status = 1 ");
            $query = DB::table('m_jabatan as i')->where ('i.status', 1);
            $datatables = DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $html = '
                        <a href="'.url('master/jabatan/'.$data->id.'/edit').'" class="mb-2 mr-2 btn btn-primary" >Ubah</a>
                        <form action="'.route('jabatan.destroy', $data->id).'" method="POST" style="display:inline-block;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="mb-2 mr-2 btn btn-danger dt-btn"
                                data-swa-text="Hapus Jabatan '.$data->name.'?">
                                Hapus
                            </button>
                        </form>';
                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('master.jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.jabatan.create');
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
            'name' => 'required|max:200',
        ]);

        DB::beginTransaction();
        try
        {
            $data = new Jabatan();
            $data->name = $request->name;
            $data->save();
            DB::commit();

            return redirect('master/jabatan')->with('success', 'Data berhasil ditambah');
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

        $data['data_edit'] = Jabatan::where('id',$id)->first();
        return view('master.jabatan.edit', $data);
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
            'name' => 'required|max:200',
        ]);
        DB::beginTransaction();
        try
        {
            $data = Jabatan::findOrFail($id);
            $data->name = $request->name;
            $data->save();

            DB::commit();

            return redirect('master/jabatan')->with('success', 'Data berhasil dirubah');
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
          $data = Jabatan::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('master/jabatan')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


}
