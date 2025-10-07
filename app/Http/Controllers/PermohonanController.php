<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentType;
use App\Models\Arsip;
use App\Models\Type;
use App\Models\Kategori;
use App\Models\Project;
use App\Models\ProjectArsip;
use App\Models\ProjectDocument;
use Auth;
use DB,DataTables;

class PermohonanController extends Controller
{
  public function index(Request $request)
  {
    if($request->ajax())
    {
      $pd_id = \Auth::user()->pd_id;
      $query = DB::select("select p.*, pd.name as perangkatdaerah from projects p
                          inner join perangkat_daerah pd on pd.id = p.pd_id
                          where p.kelengkapan = 3 and p.status = 1  and p.pd_id = $pd_id ");
      $datatables = DataTables::of($query)
          ->addColumn('action', function ($data) {
              $html = '';
              $html .=
              '<a href="'.url('project/'.$data->id.'').'" class="mb-2 mr-2 btn btn-info" ><i class="pe-7s-search btn-icon-wrapper"> </i> Detail</a>&nbsp;'.
                  '&nbsp;'
                  .\Form::open([ 'method'  => 'delete', 'route' => [ 'project.destroy', $data->id ], 'style' => 'display: inline-block;' ]).
                  '<button class="mb-2 mr-2 btn btn-danger dt-btn" data-swa-text="Hapus Aplikasi '.$data->paket_pekerjaan.'?" ><i class="pe-7s-trash btn-icon-wrapper"> </i> Hapus</button>'
                  .\Form::close();
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
    return view('permohonan.index');
  }

  public function create()
  {
    $data['kategori'] = Kategori::where('status',1)->pluck('name','id');
    return view('permohonan.create',$data);
  }

  public function step2(Request $request)
  {
    $data['data'] = Project::findOrFail($request->get('kd'));
    $data['document_type'] = DocumentType::where('type',1)->where('status',1)->get();
    return view('permohonan.create-2',$data);
  }

  public function step3(Request $request)
  {
    $data['data'] = Project::findOrFail($request->get('kd'));
    $data['arsip'] = Arsip::where('type',1)->where('status',1)->get();
    return view('permohonan.create-3',$data);
  }

  public function store(Request $request)
  {

      $this->validate($request, [
        'paket_pekerjaan' => 'required',
        'kegiatan' => 'required',
        'jenis_pekerjaan' => 'required',
        'anggaran' => 'required',
        'jangka_waktu' => 'required',
        'tanggal_mulai' => 'required',
      ]);
      DB::beginTransaction();
      try
      {
          $data = new Project();
          $data->pd_id = \Auth::user()->pd_id;
          $data->paket_pekerjaan = $request->paket_pekerjaan;
          $data->kategori_id = $request->kategori_id;
          $data->kegiatan = $request->kegiatan;
          $data->jenis_pekerjaan = $request->jenis_pekerjaan;
          $data->anggaran = replaceRp($request->anggaran);
          $data->jangka_waktu = $request->jangka_waktu;
          $data->tanggal_mulai = date('Y-m-d',strtotime($request->tanggal_mulai));
          $data->created_by = Auth::user()->id;
          $data->updated_by = Auth::user()->id;
          $data->save();

          DB::commit();

          parent::inputLog($data->id, "Pembuatan Permohonan Aplikasi", 4);

          return redirect('permohonan/step2?kd='.$data->id);
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal ditambah');
      }

  }

  public function updateStep2(Request $request)
  {
    $deskripsi = $request->deskripsi;
    $document = $request->document;
    $labelDocument = $request->labelDocument;
    $idProject = $request->id;

    $validasiCustom = 1;
    $valisasiText = "";
    for ($i=0; $i < count($deskripsi); $i++) {

      if($deskripsi[$i] == null || $deskripsi[$i] == ""){
        $validasiCustom = 0;
        $valisasiText .= $labelDocument[$i].",";
      }
    }

    if($validasiCustom == 0){
      return redirect('permohonan/step2?kd='.$idProject)
                  ->withErrors(['message1'=>'Dokumen Aplikasi belum lengkap. '.removeLastString($valisasiText)])
                  ->withInput();
    }

    DB::beginTransaction();
    try
    {

        $dataProject = Project::findOrFail($idProject);
        $dataProject->kelengkapan = 2;
        $dataProject->save();

        for ($i=0; $i < count($document); $i++) {
          $data = new ProjectDocument();
          $data->project_id = $idProject;
          $data->document_id = $document[$i];
          $data->deskripsi = $deskripsi[$i];
          $data->created_by = Auth::user()->id;
          $data->updated_by = Auth::user()->id;
          $data->save();
        }

        DB::commit();

        return redirect('permohonan/step3?kd='.$idProject);
    }
    catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
    {
        DB::rollback();
        return redirect()->back()->with('danger', 'Data gagal ditambah');
    }
  }

  public function updateStep3(Request $request)
  {
    $deskripsi = $request->deskripsi;
    $link = $request->link;
    $file = $request->file;
    $arsip = $request->arsip;
    $labelArsip = $request->labelArsip;
    $idProject = $request->id;

    $validasiCustom = 1;
    $valisasiText = "";

    for ($i=0; $i < count($link); $i++) {

      if($link[$i] == null && $file[$i] == ""){
        $validasiCustom = 0;
        $valisasiText .= $labelArsip[$i].",";
      }
    }

    if($validasiCustom == 0){
      return redirect('permohonan/step3?kd='.$idProject)
                  ->withErrors(['message1'=>'File Pendukung belum lengkap. '.removeLastString($valisasiText)])
                  ->withInput();
    }


    DB::beginTransaction();
    try
    {

        $dataProject = Project::findOrFail($idProject);
        $dataProject->kelengkapan = 3;
        $dataProject->status = $request->status;
        $dataProject->save();

        for ($i=0; $i < count($arsip); $i++) {
          $data = new ProjectArsip();
          $data->project_id = $idProject;
          $data->arsip_id = $arsip[$i];
          $data->link = $link[$i];
          $data->deskripsi = $deskripsi[$i];
          $no=1;
          if( isset( $file[$i] ) ) {
            if($request->file($file[$i]) != null){
                $image = $request->file($file[$i]);
                $nameImage = time().'-'.$no.'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/project');
                $image->move($destinationPath, $nameImage);
                $data->file = $nameImage;
                $no++;
            }
          }

          $data->created_by = Auth::user()->id;
          $data->updated_by = Auth::user()->id;
          $data->save();
        }

        DB::commit();
        if($request->status == 1){
          return redirect('permohonan')->with('success', 'Data Permohonan berhasil ditambah');
        }else{
          return redirect('draft')->with('success', 'Data Aplikasi berhasil ditambah');
        }
        
    }
    catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
    {
        DB::rollback();
        return redirect()->back()->with('danger', 'Data gagal ditambah');
    }
  }

  public function batal(Request $request)
  {
    DB::beginTransaction();
    try
    {
        $idProject = $request->get('kd');
        ProjectArsip::where('project_id', $idProject)->delete();
        ProjectDocument::where('project_id', $idProject)->delete();
        Project::where('id', $idProject)->delete();

        DB::commit();

        return redirect('permohonan/create')->with('success', 'Permohonan berhasil dibatalkan');
    }
    catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
    {
        DB::rollback();
        return redirect()->back()->with('danger', 'Data gagal dibatalkan');
    }
  }

  

}
