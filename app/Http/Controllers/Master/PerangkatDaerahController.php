<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PerangkatDaerah;
use App\Models\Type;
use App\Models\Regencie;
use Auth;
use DB,DataTables;

class PerangkatDaerahController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax())
        {
            $query = DB::select("select pd.*, r.name as regencie from perangkat_daerah pd
                                    left join regencies r on r.id = pd.regencie_id
                                    where pd.status =1 ");
            $datatables = DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $html = '';
                    $html .=
                        '<a href="'.url('master/perangkatdaerah/'.$data->id.'/edit').'" class="mb-2 mr-2 btn btn-primary" >Ubah</a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'delete', 'route' => [ 'perangkatdaerah.destroy', $data->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="mb-2 mr-2 btn btn-danger dt-btn" data-swa-text="Hapus PerangkatDaerah Dokumen '.$data->name.'?" >Hapus</button>'
                        .\Form::close();
                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('master.perangkat_daerah.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['regencie'] = Regencie::where('province_id',35)->pluck('name','id');
        return view('master.perangkat_daerah.create',$data);
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
            $data = new PerangkatDaerah();
            $data->name = $request->name;
            $data->regencie_id = $request->regencie_id;
            $data->save();

            DB::commit();

            return redirect('master/perangkatdaerah')->with('success', 'Data berhasil ditambah');
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

        $data['data_edit'] = PerangkatDaerah::where('id',$id)->first();
        $data['regencie'] = Regencie::where('province_id',35)->pluck('name','id');
        return view('master.perangkat_daerah.edit', $data);
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
            $data = PerangkatDaerah::findOrFail($id);
            $data->name = $request->name;
            $data->regencie_id = $request->regencie_id;
            $data->save();

            DB::commit();

            return redirect('master/perangkatdaerah')->with('success', 'Data berhasil dirubah');
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
          $data = PerangkatDaerah::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('master/perangkatdaerah')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


}
