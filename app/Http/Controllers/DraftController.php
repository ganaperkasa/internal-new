<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentType;
use App\Models\Arsip;
use App\Models\Type;
use App\Models\Project;
use App\Models\ProjectArsip;
use App\Models\ProjectDocument;
use App\Models\PerangkatDaerah;
use App\Models\Chat;
use App\Models\Log;
use Auth;
use DB,DataTables;

class DraftController extends Controller
{
  public function index(Request $request)
  {
    if($request->ajax())
    {
      $where = "";
      
      $where = " and p.pd_id = ".\Auth::user()->pd_id;
      $query = DB::select("select p.*, pd.name as perangkatdaerah from projects p
                          inner join perangkat_daerah pd on pd.id = p.pd_id
                          where p.status = 3  $where");
      $datatables = DataTables::of($query)
          ->addColumn('action', function ($data) {
              $html = '';
              $html .=
              '<a href="'.url('project/'.$data->id.'').'" class="mb-2 mr-2 btn btn-info" ><i class="pe-7s-search btn-icon-wrapper"> </i> Detail</a>&nbsp;'.
                  '&nbsp;';
              return $html;
          })
          ->editColumn('jenis_pekerjaan', function ($data){
            return jenisPekerjaan($data->jenis_pekerjaan);
          })
          ->editColumn('anggaran', function ($data){
            return formatNoRpComma($data->anggaran);
          })
          ->editColumn('jangka_waktu', function ($data){
            return $data->jangka_waktu." Hari";
          })
          ->rawColumns(['action']);
      return $datatables->make(true);
    }
    return view('draft.index');
  }

  public function lanjutkan(Request $request)
  {
    $id = $request->kode;

    DB::beginTransaction();
    try
    {
        $data = Project::findOrFail($id);
        $data->status = 1;
        $data->save();

        DB::commit();

        return redirect('project/'.$id)->with('success', 'Berhasil melakukan permohonan');
    }
    catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
    {
        DB::rollback();
        return redirect()->back()->with('danger', 'Data gagal dihapus');
    }
  }

}