<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\User;
use App\Models\Role;
use App\Models\Jabatan;
use Auth;
use DB,DataTables;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:2,3');
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
            $query = DB::select("select u.*, j.name as jabatan, r.name as role from users u
                                    left join m_jabatan j on j.id = u.jabatan_id
                                    left join roles r on r.id = u.role_id
                                    where u.status =1 ");
            $datatables = DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $html = '';
                    $html .=
                    '<a href="'.url('master/user/'.$data->id.'/edit').'" class="mb-2 mr-2 btn btn-primary btn-sm" >Ubah</a>'.'&nbsp;'.
                        '<a href="'.url('master/user/password/'.$data->id.'').'" class="mb-2 mr-2 btn btn-secondary btn-sm" >Password</a>'.
                        '&nbsp;'
                        .\Form::open([ 'method'  => 'delete', 'route' => [ 'user.destroy', $data->id ], 'style' => 'display: inline-block;' ]).
                        '<button class="mb-2 mr-2 btn btn-danger btn-sm dt-btn" data-swa-text="Hapus User '.$data->name.'?" >Hapus</button>'
                        .\Form::close();
                    return $html;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
        return view('master.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['jabatan'] = Jabatan::where('status', 1)->pluck('name','id');  
        $data['role'] = Role::where('status', 1)->pluck('name','id');  
        $data['divisi'] = Divisi::pluck('name','id');  
        return view('master.user.create',$data);
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
            'email' => 'required|email|unique:users|max:150',
            'password' => 'required|confirmed',
        ]);
        DB::beginTransaction();
        try
        {
            $data = new User();
            $data->email = $request->email;
            $data->name = $request->name;
            $data->tgl_msk = $request->tgl_msk;
            $data->password = bcrypt($request->password);
            $data->jabatan_id = $request->jabatan_id;
            $data->role_id = $request->role_id;
            $data->divisi_id = $request->divisi_id;
            $data->save();

            DB::commit();

            return redirect('master/user')->with('success', 'Data berhasil ditambah');
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

        $data['data_edit'] = User::where('id',$id)->first();
        $data['jabatan'] = Jabatan::where('status', 1)->pluck('name','id');
        $data['role'] = Role::where('status', 1)->pluck('name','id');  
        $data['divisi'] = Divisi::pluck('name','id');  
        return view('master.user.edit', $data);
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
            $data = User::findOrFail($id);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->jabatan_id = $request->jabatan_id;
            $data->role_id = $request->role_id;
            $data->tgl_msk = $request->tgl_msk;
            $data->divisi_id = $request->divisi_id;
            $data->save();

            DB::commit();

            return redirect('master/user')->with('success', 'Data berhasil dirubah');
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
          $data = User::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('master/user')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


    public function password($id)
    {

        $data['data_edit'] = User::where('id',$id)->first();

        $data['role'] = Role::pluck('name','id');
        return view('master.user.password', $data);
    }

    public function updatePassword(Request $request)
    {

        $this->validate($request, [
            'password' => 'required|confirmed',
        ]);
        DB::beginTransaction();
        try
        {
            $data = User::findOrFail($request->id);
            $data->password = bcrypt($request->password);
            $data->save();

            DB::commit();

            return redirect('master/user')->with('success', 'Data berhasil ditambah');
        }
        catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('danger', 'Data gagal ditambah');
        }

    }


}
