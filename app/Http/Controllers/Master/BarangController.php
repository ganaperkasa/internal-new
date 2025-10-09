<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Type;
use App\Models\Kontak;
use Auth;

class BarangController extends Controller
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
            $query = DB::table('m_barang as i')->where('i.status', 1);
            $datatables = DataTables::of($query)
                    ->addColumn('action', function ($data) {
                    $editUrl = url('master/barang/'.$data->id.'/edit');
                    $deleteUrl = route('barang.destroy', $data->id);

                    $html = '
                        <a href="'.$editUrl.'" class="mb-2 mr-2 btn btn-primary">Ubah</a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline-block;">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="mb-2 mr-2 btn btn-danger dt-btn"
                                data-swa-text="Hapus Barang '.$data->name.'?">
                                Hapus
                            </button>
                        </form>
                    ';
                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('master.barang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.barang.create');
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
            $data = new Barang();
            $data->name = $request->name;
            $data->save();
            DB::commit();

            return redirect('master/barang')->with('success', 'Data berhasil ditambah');
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

        $data['data_edit'] = Barang::where('id',$id)->first();
        return view('master.barang.edit', $data);
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
            $data = Barang::findOrFail($id);
            $data->name = $request->name;
            $data->save();

            DB::commit();

            return redirect('master/barang')->with('success', 'Data berhasil dirubah');
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
          $data = Barang::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('master/barang')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


}
