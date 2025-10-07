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
use App\Models\Kategori;
use Auth;
use DB,DataTables;

class ProjectController extends Controller
{
  public function index(Request $request)
  {
    
    if($request->ajax())
    {
      $where = "";
      if(\Auth::user()->role_id == 3){
        //Perangkat Daerah
        $where = " and p.pd_id = ".\Auth::user()->pd_id;
      }
      $query = DB::select("select p.*, pd.name as perangkatdaerah from projects p
                          inner join perangkat_daerah pd on pd.id = p.pd_id
                          where p.kelengkapan = 3 and p.status = 4  $where");
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
    return view('project.index');
  }

  public function show($id)
  {
    $data['data'] = Project::findOrFail($id);
    $data['perangkatdaerah'] = PerangkatDaerah::findOrFail($data['data']->pd_id);
    $data['kategori'] = Kategori::findOrFail($data['data']->kategori_id);
    
    $query = "select pd.*, dt.name as label_document from project_document pd
              inner join document_types dt on dt.id = pd.document_id
              where project_id = $id
              order by dt.sort asc";
    $data['document'] =DB::select($query);

    $query = "select pa.*, a.name as label_arsip from project_arsip pa
              inner join arsip a on a.id = pa.arsip_id
              where project_id = $id
              order by a.sort asc";
    $data['arsip'] =DB::select($query);

    $data['totalDokumenStatus0'] =ProjectDocument::where('konfirmasi',0)->where('project_id', $id)->count();
    $data['totalDokumenStatus1'] =ProjectDocument::where('konfirmasi',1)->where('project_id', $id)->count();
    $data['totalDokumenStatus2'] =ProjectDocument::where('konfirmasi',2)->where('project_id', $id)->count();

    $data['totalArsipStatus0'] =ProjectArsip::where('konfirmasi',0)->where('project_id', $id)->count();
    $data['totalArsipStatus1'] =ProjectArsip::where('konfirmasi',1)->where('project_id', $id)->count();
    $data['totalArsipStatus2'] =ProjectArsip::where('konfirmasi',2)->where('project_id', $id)->count();

    $query = "select l.*, u.name as petugas from logs l inner join users u on u.id = l.created_by where project_id = $id order by l.created_at desc";
    $data['log'] =DB::select($query);

    return view('project.show',$data);
  }

  public function ubah(Request $request, $id)
  {
    $data['data_edit'] = Project::findOrFail($id);
    $data['kategori'] = Kategori::where('status',1)->pluck('name','id');
    return view('project.ubah',$data);
  }

  public function simpanperubahan(Request $request, $id)
  {
    
      DB::beginTransaction();
      try
      {
        
          $data = Project::findOrFail($id);
          $data->paket_pekerjaan = $request->paket_pekerjaan;
          $data->kategori_id = $request->kategori_id;
          $data->kegiatan = $request->kegiatan;
          $data->jenis_pekerjaan = $request->jenis_pekerjaan;
          $data->anggaran = replaceRp($request->anggaran);
          $data->jangka_waktu = $request->jangka_waktu;
          $data->tanggal_mulai = date('Y-m-d',strtotime($request->tanggal_mulai));
          $data->updated_by = \Auth::user()->id;
          $data->save();

          parent::inputLog($id, "Perubahan Informasi Aplikasi", 3);

          DB::commit();

          return redirect('project/'.$id)->with('success', 'Data berhasil dirubah');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dirubah');
      }

  }

  public function edit(Request $request, $id)
  {
    $type = $request->get('type');
    if($type == 'arsip'){
      $data['data'] = ProjectArsip::findOrFail($id);
      $data['project'] = Project::findOrFail($data['data']->project_id);
      $data['label'] = Arsip::findOrFail($data['data']->arsip_id);
      return view('project.editArsip',$data);
    }else{
      $data['data'] = ProjectDocument::findOrFail($id);
      $data['project'] = Project::findOrFail($data['data']->project_id);
      $data['label'] = DocumentType::findOrFail($data['data']->document_id);
      return view('project.editDocument',$data);
    }
  }

  public function update(Request $request, $id)
  {

      DB::beginTransaction();
      try
      {
          $type = $request->type;
          $label = $request->label;
          if($type == 'dokumen'){
            $data = ProjectDocument::findOrFail($id);
            $data->deskripsi = $request->deskripsi;
            $data->konfirmasi = 0;
            $data->updated_by = \Auth::user()->id;
            $data->save();

            parent::inputLog($data->project_id, "Perubahan Dokumen $label", 3);
          }else{
            $data = ProjectArsip::findOrFail($id);
            $data->deskripsi = $request->deskripsi;
            $data->konfirmasi = 0;
            $data->link = $request->link;
            $data->updated_by = \Auth::user()->id;
            if($request->file('file') != null){
                $image = $request->file('file');
                $nameImage = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/project');
                $image->move($destinationPath, $nameImage);
                $data->file = $nameImage;
            }
            $data->save();

            parent::inputLog($data->project_id, "Perubahan Arsip $label", 3);
          }

          DB::commit();

          return redirect('project/'.$data->project_id)->with('success', 'Data berhasil dirubah');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dirubah');
      }

  }

  public function konfirmasi(Request $request)
  {
    DB::beginTransaction();
    try
    {
        $type = $request->type;
        $id = $request->kd;
        $label = $request->label;
        if($type == 'dokumen'){
          $data = ProjectDocument::findOrFail($id);
          $data->konfirmasi = 1;
          $data->save();

          parent::inputLog($data->project_id, "Konfirmasi Dokumen $label", 2);
        }else{
          $data = ProjectArsip::findOrFail($id);
          $data->konfirmasi = 1;
          $data->save();

          parent::inputLog($data->project_id, "Konfirmasi Arsip $label", 2);
        }

        $this->createDataKelengkapan($data->project_id);

        DB::commit();
        return redirect('project/'.$data->project_id)->with('success', 'Berhasil konfirmasi data');
    }
    catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
    {
        DB::rollback();
        return redirect()->back()->with('danger', 'Data gagal dirubah');
    }
  }

  public function revisi(Request $request)
  {
    $type = $request->get('type');
    $id = $request->get('kd');
    $label = $request->get('label');
    $data['labelDetail'] = $label;
    $data['type'] = $type;
    if($type == 'arsip'){
      $data['data'] = ProjectArsip::findOrFail($id);
      $data['project'] = Project::findOrFail($data['data']->project_id);
      $data['label'] = Arsip::findOrFail($data['data']->arsip_id);
      $data['labelType'] = "Arsip";

    }else{
      $data['data'] = ProjectDocument::findOrFail($id);
      $data['project'] = Project::findOrFail($data['data']->project_id);
      $data['label'] = DocumentType::findOrFail($data['data']->document_id);
      $data['labelType'] = "Dokumen";

    }

    return view('project.revisi',$data);
  }

  public function updateRevisi(Request $request)
  {
    DB::beginTransaction();
    try
    {

        $type = $request->type;
        $id = $request->kd;
        $label = $request->label;


        if($type == 'dokumen'){
          $data = ProjectDocument::findOrFail($id);
          $data->konfirmasi = 2;
          $data->save();

          parent::inputLog($data->project_id, "Permintaan Revisi Dokumen $label", 1);
          parent::inputChat($data->project_id, "Permintaan Revisi", "Dokumen $label");

        }else{
          $data = ProjectArsip::findOrFail($id);
          $data->konfirmasi = 2;
          $data->save();

          parent::inputLog($data->project_id, "Permintaan Revisi Arsip $label", 1);
          parent::inputChat($data->project_id, "Permintaan Revisi", "Arsip $label");
        }



        DB::commit();

        return redirect('project/'.$data->project_id)->with('success', 'Berhasil revisi data');
    }
    catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
    {
        DB::rollback();
        return redirect()->back()->with('danger', 'Data gagal dirubah');
    }
  }

  public function createDataKelengkapan($idProject)
  {
    
    $cekDokumen = ProjectDocument::where('project_id', $idProject)->whereIn('konfirmasi', ['0', '2'])->count();
    $cekArsip = ProjectArsip::where('project_id', $idProject)->whereIn('konfirmasi', ['0', '2'])->count();
    
    $modelProject = Project::findOrFail($idProject);
    
    if($modelProject->status == "1"){
      //Jika Status Permohonan
      if($cekArsip == 0 && $cekDokumen == 0){
        //Buat Data Kelengkapan
        $document_type = DocumentType::where('type',2)->where('status',1)->get();
        $arsip = Arsip::where('type',2)->where('status',1)->get();
  
        $dataProject = Project::findOrFail($idProject);
        $dataProject->status = 2;
        $dataProject->save();
  
        foreach($document_type as $value){
          $data = new ProjectDocument();
          $data->project_id = $idProject;
          $data->document_id = $value->id;
          $data->deskripsi = "";
          $data->created_by = Auth::user()->id;
          $data->updated_by = Auth::user()->id;
          $data->save();
        }
  
        foreach($arsip as $value){
          $data = new ProjectArsip();
          $data->project_id = $idProject;
          $data->arsip_id = $value->id;
          $data->deskripsi = "";
          $data->created_by = Auth::user()->id;
          $data->updated_by = Auth::user()->id;
          $data->save();
        }
  
      }
    }elseif($modelProject->status == "2"){
        
      if($cekArsip == 0 && $cekDokumen == 0){
        $dataProject = Project::findOrFail($idProject);
        $dataProject->status = 4;
        $dataProject->save();

        
      }
    }
    
    
    
  }

  public function destroy($id)
  {
    DB::beginTransaction();
    try
    {
        $data = Project::findOrFail($id);
        $data->status = 99;
        $data->save();

        DB::commit();

        return redirect('permohonan')->with('success', 'Data berhasil dihapus');
    }
    catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
    {
        DB::rollback();
        return redirect()->back()->with('danger', 'Data gagal dihapus');
    }
  }
}
