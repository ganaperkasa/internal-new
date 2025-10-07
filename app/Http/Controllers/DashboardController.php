<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormA;
use App\Models\FormAcoordinat;
use App\Models\FormAdampak;
use App\Models\FormAfile;
use App\Models\FormAhidrologi;
use App\Models\FormAkorban;
use App\Models\FormAlokasi;
use App\Models\FormB;
use App\Models\FormBdampak;
use App\Models\FormBfile;
use App\Models\FormBhidrologi;
use App\Models\FormBkorban;
use App\Models\FormBlokasi;
use App\Models\FormBpenyebab;
use App\Models\Log;
use App\Models\Lokasi;
use App\Models\Kewenangan;
use App\User;
use DB,Auth;

class DashboardController extends Controller
{
    private $title = "Dashboard";

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['data'] = FormA::with(['FormAcoordinat', 'FormAkorban', 'FormAfile'])->get();
        $data['dinasFormA'] = FormA::with('data_lokasi','data_wilayah')->where('status_konfirmasi', 1)->select('*')->orderBy('waktu_kejadian', 'asc')->count();
        $data['dinasFormB'] = FormB::with('data_lokasi','data_wilayah')->where('status_konfirmasi', 1)->select('*')->orderBy('waktu_kejadian', 'asc')->count();
        $data['kepalaFormA'] = FormA::with('data_lokasi','data_wilayah')->where('status_konfirmasi', 2)->select('*')->orderBy('waktu_kejadian', 'asc')->count();
        $data['kepalaFormB'] = FormB::with('data_lokasi','data_wilayah')->where('status_konfirmasi', 2)->select('*')->orderBy('waktu_kejadian', 'asc')->count();
        return view('dashboard', $data);
    }


    public function dashboard(Request $request)
    {

        $StartDate = formatDatePhp($request->get('StartDate'));
        $EndDate = formatDatePhp($request->get('EndDate'));
        $status = $request->status;

        $data = FormA::with([
            'FormAcoordinat' => function($query){
                $query->select('id', 'form_a_id', 'latitude', 'longitude');
            },
        ])->whereBetween('waktu_kejadian', [$StartDate." 00:00:00", $EndDate." 23:00:00"]);

        if($status != "null"){
          $data = $data->where('status_konfirmasi',$status)->get();
        }else{
          $data = $data->get();
        }


        $returnData = [
          'header'=>$data,
        ];

        return response()->json(array('data'=> $data), 200);
    }

    public function getDataDashboard(Request $request)
    {
      $StartDate = formatDatePhp($request->get('StartDate'));
      $EndDate = formatDatePhp($request->get('EndDate'));
      $status = $request->status;

      $petugasSurvey = User::where('role_id',12)->where('status',1)->count();

      $query = "select count(*) total  from form_a fa WHERE (fa.waktu_kejadian BETWEEN '$StartDate 00:00:00' AND '$EndDate 23:00:00')";
      if($status != "null"){
        $query .= " and fa.status_konfirmasi = $status";
      }
      $dataFormA = DB::select($query);


      $query = "select count(*) total  from form_b fa WHERE (fa.waktu_kejadian BETWEEN '$StartDate 00:00:00' AND '$EndDate 23:00:00')";
      if($status != "null"){
        $query .= " and fa.status_konfirmasi = $status";
      }
      $dataFormB = DB::select($query);

      $query = "select count(*) total  from form_b fa
      inner join form_b_image fi on fi.form_b_id = fa.id
      WHERE (fa.waktu_kejadian BETWEEN '$StartDate 00:00:00' AND '$EndDate 23:00:00')";
      if($status != "null"){
        $query .= " and fa.status_konfirmasi = $status";
      }
      $dataLokasiB = DB::select($query);


      $query = "select fa.id as forma_id, ws.nama as wilayah_sungai, l.nama as lokasi,waktu_kejadian,status_konfirmasi, nama_sungai, das_nm,  u.name as petugas from form_a fa
                  inner join wilayah_sungai ws on ws.id = fa.wilayah_sungai_id
                  inner join lokasi l on l.id = lokasi_id
                  left join users u on u.id = fa.created_by
                  order by fa.created_at desc limit 5";
      $lastFormA = DB::select($query);
      foreach ($lastFormA as $key => $value) {
        $value->waktu_kejadian = tglWaktuIndo($value->waktu_kejadian);
      }

      $query = "select fa.form_a_id as forma_id, ws.nama as wilayah_sungai, l.nama as lokasi,waktu_kejadian,status_konfirmasi, nama_sungai, das_nm,  u.name as petugas from form_b fa
                  inner join wilayah_sungai ws on ws.id = fa.wilayah_sungai_id
                  inner join lokasi l on l.id = lokasi_id
                  left join users u on u.id = fa.created_by
                  order by fa.created_at desc limit 5";
      $lastFormB = DB::select($query);
      foreach ($lastFormB as $key => $value) {
        $value->waktu_kejadian = tglWaktuIndo($value->waktu_kejadian);
      }
      $returnData = [
        'petugasSurvey'=>$petugasSurvey,
        'totalFormA'=>$dataFormA[0]->total,
        'totalFormB'=>$dataFormB[0]->total,
        'totalLokasiFormB'=>$dataLokasiB[0]->total,
        'lastFormA'=>$lastFormA,
        'lastFormB'=>$lastFormB,
      ];

      return response()->json(array('data'=> $returnData), 200);
    }

    public function getDataMapsFormB($id)
    {
      $returnData = FormBfile::where('form_b_id', $id)->get();
      return response()->json(array('data'=> $returnData), 200);
    }

    public function oneSignal(Request $request)
    {

        $user_id = Auth::user()->id;
        $users = User::findOrFail($user_id);
        $users->onesignal_browser =$request->userId;
        $users->save();

    }


    public function formADetail($id)
    {
      $statusFormB = "0";
      $data['idFormB'] = 0;

      //Form A
      $data['title']  = 'Data Form A';
      $dataFormA = FormA::with('data_lokasi','data_wilayah')->findOrFail($id);
      $data['data'] = $dataFormA;
      $data['korban'] = FormAkorban::where('form_a_id', $id)->get();
      $data['file'] = FormAfile::where('form_a_id', $id)->get();
      $data['hidrologi'] = FormAhidrologi::where('form_a_id', $id)->get();
      $data['dampakGenangan'] = FormAdampak::where('form_a_id', $id)->where('jenis_dampak','Dampak Genangan')->get();
      $data['dampakKerusakan'] = FormAdampak::where('form_a_id', $id)->where('jenis_dampak','Dampak Kerusakan')->get();
      $data['log'] = Log::with('data_user')->where('form_id', $id)->where('type',1)->orderBy('created_at', 'DESC')->get();

      $data['province'] = FormAlokasi::with('data_province')->select('province_id')->where('form_a_id', $id)->groupBy('province_id')->get();
      $data['regencie'] = FormAlokasi::with('data_regencie')->select('regencie_id')->where('form_a_id', $id)->groupBy('regencie_id')->get();
      $data['district'] = FormAlokasi::with('data_district')->select('district_id')->where('form_a_id', $id)->groupBy('district_id')->get();

      $qryForm = "select v.name,v.id from form_a_lokasi f inner join villages v on f.village_id =v.id where f.form_a_id = $id group by v.name,v.id";
      $data['village'] = DB::select($qryForm);

      $lokasi = Lokasi::where('id', $dataFormA->lokasi_id)->first();
      $kewenangan = Kewenangan::where('id', $dataFormA->kewenangan_id)->first();
      $petugas = User::where('id', $dataFormA->created_by)->first();

      $data['lokasiFormA'] = $lokasi->nama;
      $data['kewenanganFormA'] = $kewenangan->nama;
      $data['petugasFormA'] = $petugas->name;

      //Form B
      $checkFormB = FormB::where('form_a_id', $id)->count();
      if($checkFormB != 0){
        $statusFormB = "1";
        $idFormB = FormB::where('form_a_id', $id)->first();
        $idFormB = $idFormB->id;
        $dataFormB = FormB::with('data_lokasi','data_wilayah')->findOrFail($idFormB);
        $data['idFormB'] = $idFormB;
        $data['dataFormB'] = $dataFormB;
        $data['korbanFormB'] = FormBkorban::where('form_b_id', $idFormB)->get();
        $data['fileFormB'] = FormBfile::where('form_b_id', $idFormB)->get();
        $data['hidrologiFormB'] = FormBhidrologi::where('form_b_id', $idFormB)->get();
        $data['dampakGenanganFormB'] = FormBdampak::where('form_b_id', $idFormB)->where('jenis_dampak','Dampak Genangan')->get();
        $data['dampakKerusakanFormB'] = FormBdampak::where('form_b_id', $idFormB)->where('jenis_dampak','Dampak Kerusakan')->get();
        $data['penyebabFormB'] = FormBpenyebab::where('form_b_id', $idFormB)->get();
        $data['logFormB'] = Log::with('data_user')->where('form_id', $idFormB)->where('type',2)->orderBy('created_at', 'DESC')->get();

        $data['provinceFormB'] = FormBlokasi::with('data_province')->select('province_id')->where('form_b_id', $id)->groupBy('province_id')->get();
        $data['regencieFormB'] = FormBlokasi::with('data_regencie')->select('regencie_id')->where('form_b_id', $id)->groupBy('regencie_id')->get();
        $data['districtFormB'] = FormBlokasi::with('data_district')->select('district_id')->where('form_b_id', $id)->groupBy('district_id')->get();

        $qryForm = "select v.name,v.id from form_b_lokasi f inner join villages v on f.village_id =v.id where f.form_b_id = $idFormB group by v.name,v.id";
        $data['villageFormB'] = DB::select($qryForm);

        $lokasi = Lokasi::where('id', $dataFormB->lokasi_id)->first();
        $kewenangan = Kewenangan::where('id', $dataFormB->kewenangan_id)->first();
        $petugas = User::where('id', $dataFormB->created_by)->first();

        $data['lokasiFormB'] = $lokasi->nama;
        $data['kewenanganFormB'] = $kewenangan->nama;
        $data['petugasFormB'] = $petugas->name;
      }

      $data['statusFormB'] = $statusFormB;

      return view('modals.formADetail', $data);
    }

}
