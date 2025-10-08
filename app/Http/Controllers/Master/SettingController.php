<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Type;
use App\Models\Kontak;
use Auth;
use DB,DataTables;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:5');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = 1;
        $data['data_edit'] = Setting::where('id',$id)->first();
        return view('master.setting.index', $data);
        
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
            
        ]);
        DB::beginTransaction();
        try
        {
            $data = Setting::findOrFail($id);
            $data->last_number_sep = $request->last_number_sep;
            $data->last_number_dir = $request->last_number_dir;
            $data->last_number_msk = $request->last_number_msk;
            $data->save();

            DB::commit();

            return redirect('master/setting')->with('success', 'Data berhasil dirubah');
        }
        catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with('danger', 'Data gagal dirubah');
        }

    }


}
