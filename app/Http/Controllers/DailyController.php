<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use DB;

class DailyController extends Controller
{
    public function report(Request $request)
    {
        
    	if($request->ajax())
        {
            $user = $request->get('user');
            $bulan = $request->get('bulan');
            $tahun = $request->get('tahun');

            $where = "";
            if($user != null){
                $where .= " and a.user_by  = ".$user;
            }

            $query = DB::select("select a.*, u.name as pegawai from agendas a inner join users u on u.id = a.user_by
                                where a.status != 0 and MONTH(tanggal) = '$bulan' and YEAR(tanggal) = '$tahun' $where
                                order by a.tanggal asc");

            $data['data']=$query;
            return view('agenda.report-data',$data);
        }

    	$data['user'] = DB::table('users')
    						->select('*')
    						->where('status', '=', 1)
    						->pluck('name', 'id');

        return view('agenda.report', $data);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $levels = Agenda::where('pelaksana', Auth::id())
                ->where('status', 1)
                ->where('user_by', Auth::id())
                ->select('*');

            return DataTables::of($levels)
                ->addColumn('action', function ($data) {
                    $editUrl = route('daily.edit', $data->id);
                    $deleteUrl = route('daily.destroy', $data->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <a href="'.$editUrl.'" class="btn btn-primary btn-sm mb-1">Ubah</a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline-block;" class="delete-form">
                            '.$csrf.$method.'
                            <button type="submit" class="btn btn-danger btn-sm"
                                data-swa-text="Hapus Laporan Harian '.$data->judul.'?">
                                Hapus
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('agenda.index');
    }

  public function create(Request $request)
  {

    return view('agenda.create',array(

    ));

  }

  public function store(Request $request)
    {
        if (auth()->user()->id != "45") {
            $request->validate([
                // 'judul' => 'required',
                // 'tempat' => 'required',
                'aktifitas' => 'required',
                'jam1' => 'required',
                'jam2' => 'required',
                'tanggal' => 'required|date',
            ]);
        }

        DB::beginTransaction();

        try {
            $data = new Agenda();
            // $data->judul = $request->judul;
            $data->tempat = $request->tempat;
            $data->perihal = $request->aktifitas;
            $data->jam1 = $request->jam1;
            $data->jam2 = $request->jam2;
            $data->tanggal = date('Y-m-d', strtotime($request->tanggal));
            $data->pelaksana = auth()->id();
            $data->user_by = auth()->id();
            $data->save();

            DB::commit();

            return redirect('daily')->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('danger', 'Data gagal ditambah: ' . $e->getMessage());
        }
    }



    public function edit($id)
    {
        $data['data_edit'] = Agenda::where('id',$id)->first();
        // $data['data_edit']->tanggal = formatDateView($data['data_edit']->tanggal);
        $data['data_edit']->aktifitas = $data['data_edit']->perihal;
        return view('agenda.edit', $data);
    }


    public function update(Request $request, $id)
    {
        if (auth()->id() != 45) {
            $request->validate([
                'aktifitas' => 'required|string',
                'jam1' => 'required|string',
                'jam2' => 'required|string',
                'tanggal' => 'required|date',
            ]);
        }

        DB::beginTransaction();

        try {
            $data = Agenda::findOrFail($id);

            $data->fill([
                'tempat'   => $request->tempat,
                'perihal'  => $request->aktifitas,
                'jam1'     => $request->jam1,
                'jam2'     => $request->jam2,
                'tanggal'  => date('Y-m-d', strtotime($request->tanggal)),
            ])->save();

            DB::commit();
            return redirect('daily')->with('success', 'Data berhasil dirubah');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('danger', 'Data gagal dirubah');
        }
    }



    public function destroy($id)
    {
      DB::beginTransaction();
      try
      {
          $data = Agenda::findOrFail($id);
          $data->status = 0;
          $data->save();

          DB::commit();

          return redirect('daily')->with('success', 'Data berhasil dihapus');
      }
      catch(\Yajra\Pdo\Oci8\Exceptions\Oci8Exception $e)
      {
          DB::rollback();
          return redirect()->back()->with('danger', 'Data gagal dihapus');
      }
    }

}
