<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use App\Models\Type;
use Auth;
use DB,DataTables;

class DocumentTypeController extends Controller
{
    private $title = "Jenis Dokumen";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax())
        {
            $dataQuery = DocumentType::where('status', 1)->select('*');
            $datatables = DataTables::of($dataQuery)
                ->addColumn('action', function ($data) {
                    $html = '';
                    $html .=
                        '<a href="'.url('master/jenis/'.$data->id.'/edit').'" class="mb-2 mr-2 btn btn-primary" >Ubah</a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'delete', 'route' => [ 'jenis.destroy', $data->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="mb-2 mr-2 btn btn-danger dt-btn" data-swa-text="Hapus Jenis Dokumen '.$data->name.'?" >Hapus</button>'
                        .\Form::close();
                    return $html;
                })
                ->editColumn('type',function ($data){
                  return typeDokumen($data->type);
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('master.document_type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['type'] = Type::pluck('name','id');
        return view('master.document_type.create',$data);
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
            $data = new DocumentType();
            $data->name = $request->name;
            $data->type = $request->type;
            $data->step = $request->step;
            $data->save();

            DB::commit();

            return redirect('master/jenis')->with('success', 'Data berhasil ditambah');
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

        $data['data_edit'] = DocumentType::where('id',$id)->first();
        $data['type'] = Type::pluck('name','id');
        return view('master.document_type.edit', $data);
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
            $data = DocumentType::findOrFail($id);
            $data->name = $request->name;
            $data->type = $request->type;
            $data->step = $request->step;
            $data->save();

            DB::commit();

            return redirect('master/jenis')->with('success', 'Data berhasil dirubah');
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
          $data = DocumentType::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('master/jenis')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


}
