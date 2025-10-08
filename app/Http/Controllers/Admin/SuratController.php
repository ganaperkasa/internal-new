<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Surat;
use App\Models\Setting;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PDO;

class SuratController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = DB::table('adm_surat as s')
                ->join('m_instansi as i', 'i.id', '=', 's.instansi_id')
                ->join('users as u', 'u.id', '=', 's.created_by')
                ->select(
                    's.*',
                    'u.name as created',
                    'i.name as instansi'
                )
                ->where('s.status', 1)
                ->orderByDesc('s.tanggal');

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $html = '';
                    $html .=
                        '<a href="' . url('admin/surat/' . $data->id . '/edit') . '" class="mb-2 mr-2 btn btn-primary">Ubah</a>' .
                        '<a href="' . url('admin/surat/' . $data->id) . '" class="mb-2 mr-2 btn btn-success">Detail</a>' .
                        '<form method="POST" action="' . route('surat.destroy', $data->id) . '" style="display:inline-block">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="mb-2 mr-2 btn btn-danger dt-btn" data-swa-text="Hapus Surat ' . $data->number . '?">Hapus</button>'
                        . '</form>';
                    return $html;
                })
                ->addColumn('tahun', function ($data) {
                    return substr($data->tanggal, 0, 4);
                })
                ->editColumn('tanggal', function ($data) {
                    return tglIndo($data->tanggal);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.surat.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['instansi'] = Instansi::where('status',1)->orderBy('name')->pluck('name','id');
        return view('admin.surat.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'instansi_id' => 'required',
            'perihal'     => 'required',
            // 'address'  => 'required',
            'tanggal'     => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            $setting = Setting::find(1);
            $type = $request->type;

            $msk_char = "";
            $getTanggal = $request->tanggal;
            $bulan = date('m', strtotime($getTanggal));
            $tahun = date('y', strtotime($getTanggal));
            $fullTahun = date('Y', strtotime($getTanggal));

            if ($type == "MSK") {
                $getLast = Surat::whereRaw("
                    number = (select max(number) from adm_surat
                            where type = 'MSK' and year(tanggal) = '$fullTahun')
                    and status = 1
                ")->first();

                if ($getLast == null) {
                    $formatNomor = '001';
                } else {
                    $nowMonth = date('m');
                    $nowYear  = date('Y');

                    if ($nowMonth == $bulan && $fullTahun == $nowYear) {
                        $getNomor = substr($getLast->number, 0, 3);
                        $getNomor = (int)$getNomor + 1;
                        $formatNomor = str_pad($getNomor, 3, '0', STR_PAD_LEFT);
                    } else {
                        $getLastMonth = Surat::whereRaw("
                            LEFT(number,3) = (select max(LEFT(number,3)) from adm_surat
                                            where type = 'MSK'
                                            and month(tanggal) = '$bulan'
                                            and year(tanggal) = '$fullTahun')
                            and status = 1
                        ")->first();

                        if ($getLastMonth == null) {
                            $getNomor = substr($getLast->number, 0, 3);
                            $getNomor = (int)$getNomor + 1;
                            $formatNomor = str_pad($getNomor, 3, '0', STR_PAD_LEFT);
                        } else {
                            $getLastChar = Surat::whereRaw("
                                msk_char = (select max(msk_char) from adm_surat
                                            where type = 'MSK'
                                            and month(tanggal) = '$bulan'
                                            and year(tanggal) = '$fullTahun')
                                and status = 1
                            ")->first();

                            if ($getLastChar->msk_char == "") {
                                $msk_char = "A";
                            } else {
                                $lastChar = $getLastChar->msk_char;
                                $lastChar++;
                                $msk_char = $lastChar;
                            }

                            $getNomor = substr($getLastMonth->number, 0, 3);
                            $formatNomor = $getNomor . "." . $msk_char;
                        }
                    }
                }

                $romawi = [
                    "01" => "I", "02" => "II", "03" => "III", "04" => "IV",
                    "05" => "V", "06" => "VI", "07" => "VII", "08" => "VIII",
                    "09" => "IX", "10" => "X", "11" => "XI", "12" => "XII"
                ];
                $romawiBulan = $romawi[$bulan] ?? "";

                $type_msk = $request->type_msk;
                if ($type_msk == 'SK1') {
                    $type_msk = 'SK';
                }

                $nomor = "$formatNomor/$romawiBulan/$fullTahun/$type_msk/MSK";
            } elseif ($type == "SEP") {
                $getLast = Surat::whereRaw("
                    number = (select max(number) from adm_surat
                            where type = 'SEP'
                            and month(tanggal) = '$bulan'
                            and year(tanggal) = '$fullTahun')
                    and status = 1
                ")->first();

                if ($getLast == null) {
                    $getNomor = '001';
                } else {
                    $getNomor = (int)substr($getLast->number, 0, 3) + 1;
                }

                $formatNomor = str_pad($getNomor, 3, '0', STR_PAD_LEFT);
                $nomor = "$formatNomor/$bulan$tahun/SEP";
            } elseif ($type == "DIR") {
                $getLast = Surat::whereRaw("
                    number = (select max(number) from adm_surat
                            where type = 'DIR'
                            and month(tanggal) = '$bulan'
                            and year(tanggal) = '$fullTahun')
                    and status = 1
                ")->first();

                if ($getLast == null) {
                    $getNomor = 1;
                } else {
                    $getNomor = (int)substr($getLast->number, 0, 3) + 1;
                }

                $formatNomor = str_pad($getNomor, 3, '0', STR_PAD_LEFT);
                $nomor = "$formatNomor/$bulan$tahun/DIR";
            } else {
                return redirect()->back()->with('danger', 'Data gagal ditambah');
            }

            $data = new Surat();
            $data->number      = $nomor;
            $data->msk_char    = $msk_char;
            $data->instansi_id = $request->instansi_id;
            $data->address     = $request->address;
            $data->perihal     = $request->perihal;
            $data->type        = $request->type;
            $data->tanggal     = date('Y-m-d', strtotime($request->tanggal));

            if ($request->hasFile('document')) {
                $req  = $request->file('document');
                $file = rand() . '.' . $req->getClientOriginalExtension();
                $req->move(public_path('uploads/surat/'), $file);
                $data->document = $file;
            }

            $data->created_by = auth()->id();
            $data->updated_by = auth()->id();
            $data->save();

            DB::commit();

            return redirect('admin/surat/' . $data->id)->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('danger', 'Data gagal ditambah: ' . $e->getMessage());
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

        $data['data_edit'] = Surat::where('id',$id)->first();
        $data['instansi'] = Instansi::findOrFail($data['data_edit']->instansi_id);
        $data['user'] = User::findOrFail($data['data_edit']->created_by);

        return view('admin.surat.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['data_edit'] = Surat::where('id',$id)->first();
        $data['instansi'] = Instansi::where('status',1)->orderBy('name')->pluck('name','id');
        return view('admin.surat.edit', $data);
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
            'perihal' => 'required',
            // 'address' => 'required',
            'tanggal' => 'required',
        ]);
        DB::beginTransaction();
        try
        {
            $data = Surat::findOrFail($id);
            $data->instansi_id = $request->instansi_id;
            $data->address = $request->address;
            $data->perihal = $request->perihal;
            $data->tanggal = date('Y-m-d',strtotime($request->tanggal));

            if($request->hasFile('document')){
                $req = $request->file('document');
                $file = rand().'.'.$req->getClientOriginalExtension();
                $req->move(public_path('uploads/surat/'),$file);
                $data->document = $file;
            }

            $data->updated_by = \Auth::user()->id;
            $data->save();

            DB::commit();

            return redirect('admin/surat')->with('success', 'Data berhasil dirubah');
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
          $data = Surat::findOrFail($id);
          $data->status = 0;
          $data->delete();

          DB::commit();

          return redirect('admin/surat')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }


}
