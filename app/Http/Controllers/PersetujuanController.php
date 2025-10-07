<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentType;
use App\Models\Arsip;
use App\Models\Type;
use Auth;
use DB,DataTables;

class PersetujuanController extends Controller
{
  public function index(Request $request)
  {
    if($request->ajax())
    {
     
      $query = DB::select("select p.*, pd.name as perangkatdaerah from projects p
                          inner join perangkat_daerah pd on pd.id = p.pd_id
                          where p.kelengkapan = 3 and p.status = 1  ");
      $datatables = DataTables::of($query)
          ->addColumn('action', function ($data) {
              $html = '';
              $html .=
              '<a href="'.url('project/'.$data->id.'').'" class="mb-2 mr-2 btn btn-info" ><i class="pe-7s-search btn-icon-wrapper"> </i> Detail</a>&nbsp;';
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
    return view('persetujuan.index');
  }


}
