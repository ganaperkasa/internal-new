<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Project;
use App\Models\TypeProject;
use App\Models\Setting;
use App\User;
use Auth;
use DB,DataTables;
use PDO;

class ProjectController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:5,6');
    }
  

    public function index(Request $request)
    {

        if($request->ajax())
        {
            $query = DB::select("select s.*, u.name as created,m.name as marketing, i.name as instansi from adm_project s
                                inner join m_instansi i on i.id = s.instansi_id
                                inner join users u on u.id = s.created_by
                                inner join users m on m.id = s.marketing_id
                                where s.status = 1 order by s.start desc");
            $datatables = DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $html = '';
                    $html .=
                        '<a href="'.url('admin/project/'.$data->id.'/edit').'" class="mb-2 mr-2 btn btn-primary" >Ubah</a>'.
                        '<a href="'.url('admin/project/'.$data->id.'').'" class="mb-2 mr-2 btn btn-success" >Detail</a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'delete', 'route' => [ 'project.destroy', $data->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="mb-2 mr-2 btn btn-danger dt-btn" data-swa-text="Hapus Pekerjaan '.$data->name.'?" >Hapus</button>'
                        .\Form::close();
                    return $html;
                })
                ->editColumn('start',function($data){
                    return tglIndo($data->start);
                })
                ->editColumn('end',function($data){
                    return tglIndo($data->end);
                })
                ->editColumn('progress',function($data){
                    return $data->progress."%";
                })
                ->editColumn('time',function($data){
                    return $data->time." ".$data->time_type;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('admin.project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['user'] = User::where('status',1)->where('pic',1)->orderBy('name')->pluck('name','id');
        $data['instansi'] = Instansi::where('status',1)->orderBy('name')->pluck('name','id');
        $data['type'] = TypeProject::where('status',1)->orderBy('name')->pluck('name','id');
        return view('admin.project.create',$data);
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
            'instansi_id' => 'required',
            'name' => 'required',
            'start' => 'required',
            'end' => 'required',
            'time' => 'required',
            'progress' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $data = new Project();
            $data->instansi_id = $request->instansi_id;
            $data->name = $request->name;
            $data->perusahaan = $request->perusahaan;
            $data->type_project_id = $request->type_project_id;
            $data->nominal = replaceRp($request->nominal);
            $data->start = date('Y-m-d',strtotime($request->start));
            $data->end = date('Y-m-d',strtotime($request->end));
            $data->time = $request->time;
            $data->progress = $request->progress;
            $data->catatan = $request->catatan;
            $data->marketing_id = $request->marketing_id;
            $data->time_type = $request->time_type;
            $data->created_by = \Auth::user()->id;
            $data->updated_by = \Auth::user()->id;
            $data->save();

            DB::commit();

            return redirect('admin/project/'.$data->id)->with('success', 'Data berhasil ditambah');
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

        $data['data_edit'] = Project::where('id',$id)->first();
        $data['type'] = TypeProject::findOrFail($data['data_edit']->type_project_id);
        $data['instansi'] = Instansi::findOrFail($data['data_edit']->instansi_id);
        $data['user'] = User::findOrFail($data['data_edit']->created_by);
        $data['update'] = User::findOrFail($data['data_edit']->updated_by);
        $data['marketing'] = User::where('id',$data['data_edit']->marketing_id)->first();
        
        return view('admin.project.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['data_edit'] = Project::where('id',$id)->first();
        $data['user'] = User::where('status',1)->where('pic',1)->orderBy('name')->pluck('name','id');
        $data['type'] = TypeProject::where('status',1)->orderBy('name')->pluck('name','id');
        $data['instansi'] = Instansi::where('status',1)->orderBy('name')->pluck('name','id');
        return view('admin.project.edit', $data);
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
            'instansi_id' => 'required',
            'name' => 'required',
            'start' => 'required',
            'end' => 'required',
            'time' => 'required',
            'progress' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $data = Project::findOrFail($id);
            $data->instansi_id = $request->instansi_id;
            $data->name = $request->name;
            $data->perusahaan = $request->perusahaan;
            $data->type_project_id = $request->type_project_id;
            $data->nominal = replaceRp($request->nominal);
            $data->start = date('Y-m-d',strtotime($request->start));
            $data->end = date('Y-m-d',strtotime($request->end));
            $data->time = $request->time;
            $data->progress = $request->progress;
            $data->catatan = $request->catatan;
            $data->marketing_id = $request->marketing_id;
            $data->time_type = $request->time_type;
            $data->updated_by = \Auth::user()->id;
            $data->save();

            DB::commit();

            return redirect('admin/project')->with('success', 'Data berhasil dirubah');
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
          $data = Project::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('admin/project')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


}
