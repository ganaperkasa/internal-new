<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\CutiDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dataSemua()
    {
        if (Auth::user()->role_id == 1) {
            $user = User::with(['cuti' => function ($q) {
                $q->latest()->where('status', '1')->whereNotNull('sisa');
            }])
            ->whereHas('cuti', function ($q) {
                $q->latest()->where('status', '1')->whereNotNull('sisa');
            })->get();
        }else{
            $user = User::with(['cuti' => function ($q) {
                $q->latest()->where('status', '1')->where('user_cuti', Auth::user()->id)->whereNotNull('sisa');
            }])
            ->whereHas('cuti', function ($q) {
                $q->latest()->where('status', '1')->where('user_cuti', Auth::user()->id)->whereNotNull('sisa');
            })->get();
        }

        return view('cuti.semua-data', compact('user'));
    }

    public function index()
    {

        $data = Cuti::with('detail')->latest();

        if (Auth::user()->role_id == 1) {
            $data = $data->get();
            $jumlah = 0;
        }else{
            $data = $data->where('user_cuti', Auth::user()->id)->orderBy('created_at','DESC')->get();
            $jumlah = $data->where('status', 0)->count();
        }

        return view('cuti.index', compact('data', 'jumlah'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pj = User::all();
        if (Auth::user()->role_id == 1) {
            $user = User::all();
        }else{
            $user = User::find(Auth::user()->id);
        }

        $data['tau'] = User::find('52');
        $data['setuju'] = User::find('44');

        // dd($user);

        return view('cuti.create', compact('user', 'data', 'pj'));
    }

    public function getData($id, Request $request)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $tanggalMasuk = Carbon::parse($user->tgl_msk);

        $currentYear = (int) date('Y');
        $date = $tanggalMasuk->copy()->year($currentYear)->format('Y-m-d');

        $cuti = 0;
        $responseData = [];

        if ($date > Carbon::now()->format('Y-m-d')) {
            $responseData['pawal'] = $tanggalMasuk->copy()->year($currentYear - 1)->format('Y-m-d');
            $responseData['pakhir'] = $date;
            $responseData['p2awal'] = $date;
            $responseData['p2akhir'] = $tanggalMasuk->copy()->year($currentYear + 1)->format('Y-m-d');

            if ($request->param == 0) {
                $cuti = CutiDetail::whereHas('cuti', function ($q) use($user) {
                    $q->where('user_cuti', $user->id)->where('status' ,'1');
                })->whereDate('tanggal_cuti', '>=', $responseData['pawal'])
                ->whereDate('tanggal_cuti', '<=', $responseData['pakhir'])
                ->where('status', '1')->count();
            } else {
                $cuti = CutiDetail::whereHas('cuti', function ($q) use($user) {
                    $q->where('user_cuti', $user->id)->where('status' ,'1');
                })->whereDate('tanggal_cuti', '>=', $responseData['p2awal'])
                ->whereDate('tanggal_cuti', '<=', $responseData['p2akhir'])
                ->where('status', '1')->count();
            }
        } else {
            $responseData['pawal'] = $date;
            $responseData['pakhir'] = $tanggalMasuk->copy()->year($currentYear + 1)->format('Y-m-d');
            $responseData['p2awal'] = $tanggalMasuk->copy()->year($currentYear + 1)->format('Y-m-d');
            $responseData['p2akhir'] = $tanggalMasuk->copy()->year($currentYear + 2)->format('Y-m-d');

            if ($request->param == 0) {
                $cuti = CutiDetail::whereHas('cuti', function ($q) use($user) {
                    $q->where('user_cuti', $user->id)->where('status' ,'1');
                })->whereDate('tanggal_cuti', '>=', $responseData['pawal'])
                ->whereDate('tanggal_cuti', '<=', $responseData['pakhir'])
                ->where('status', '1')->count();
            } else {
                $cuti = CutiDetail::whereHas('cuti', function ($q) use($user) {
                    $q->where('user_cuti', $user->id)->where('status' ,'1');
                })->whereDate('tanggal_cuti', '>=', $responseData['p2awal'])
                ->whereDate('tanggal_cuti', '<=', $responseData['p2akhir'])
                ->where('status', '1')->count();
            }
        }

        return response()->json([
            'periods' => $responseData,
            'cuti_count' => $cuti,
            'user_name' => $user->name
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
{
    // dd($request->all());
    $request->validate([
        'file' => 'nullable|mimes:pdf,png,jpg,jpeg',
        'user_cuti' => 'required|exists:users,id',
        'user_setuju' => 'required|exists:users,id',
        'user_tau' => 'required|exists:users,id',
        'user_pj' => 'required|exists:users,id',
        'keterangan' => 'required',
        'tanggal.*' => 'required'
    ]);

    DB::beginTransaction();
    try {
        $cuti = Cuti::where('user_cuti', $request->user_cuti)->where('status', '0')->count();

        if ($cuti != 0 ) {
           return redirect()->back()->with('dangerss', 'Pegawai masih memiliki cuti yang belum di verifikasi');
        }

        $user = User::find($request->user_cuti);
        $tanggalMasuk = Carbon::parse($user->tgl_msk);

        // PERBAIKAN: Gunakan integer untuk tahun dan copy()
        $currentYear = (int) date('Y');
        $date = $tanggalMasuk->copy()->year($currentYear)->format('Y-m-d');

        if ($date > Carbon::now()->format('Y-m-d')) {
            if ($request->pilihan == 0) {
                //periode sekarang
                $tanggal['pawal'] = $tanggalMasuk->copy()->year($currentYear - 1)->format('Y-m-d');
                $tanggal['pakhir'] = $date;

                $cuti = CutiDetail::whereHas('cuti', function ($q) use($user) {
                    $q->where('user_cuti', $user->id)->where('status' ,'1');
                })->whereDate('tanggal_cuti', '>=', $tanggal['pawal'])
                  ->whereDate('tanggal_cuti' ,'<=', $tanggal['pakhir'])
                  ->where('status' ,'1')->count();

                if ((count($request->tanggal) +  $cuti) >  12) {
                    return redirect()->back()->with('dangerss', 'Jumlah Cuti melebihi sisa batas');
                }

                foreach ($request->tanggal as $value) {
                    if ($value < $tanggal['pawal'] || $value >= $tanggal['pakhir']) {
                        return redirect()->back()->with('dangerss', 'Jadwal di luar rentang tanggal yang valid.');
                    }
                }

            } else {
                $tanggal['p2awal'] = $date;
                $tanggal['p2akhir'] = $tanggalMasuk->copy()->year($currentYear + 1)->format('Y-m-d');

                $cuti = CutiDetail::whereHas('cuti', function ($q) use($user) {
                    $q->where('user_cuti', $user->id)->where('status' ,'1');
                })->whereDate('tanggal_cuti', '>=', $tanggal['p2awal'])
                  ->whereDate('tanggal_cuti' ,'<=', $tanggal['p2akhir'])
                  ->where('status' ,'1')->count();

                if ((count($request->tanggal) +  $cuti) >  12) {
                    return redirect()->back()->with('dangerss', 'Jumlah Cuti melebihi sisa batas');
                }

                foreach ($request->tanggal as $value) {
                    if ($value < $tanggal['p2awal'] || $value >= $tanggal['p2akhir']) {
                        return redirect()->back()->with('dangerss', 'Jadwal di luar rentang tanggal yang valid.');
                    }
                }
            }
        } else {
            if ($request->pilihan == 0) {
                //periode sekarang
                $tanggal['pawal'] = $date;
                $tanggal['pakhir'] = $tanggalMasuk->copy()->year($currentYear + 1)->format('Y-m-d');

                $cuti = CutiDetail::whereHas('cuti', function ($q) use($user) {
                    $q->where('user_cuti', $user->id)->where('status' ,'1');
                })->whereDate('tanggal_cuti', '>=', $tanggal['pawal'])
                  ->whereDate('tanggal_cuti' ,'<=', $tanggal['pakhir'])
                  ->where('status' ,'1')->count();

                if ((count($request->tanggal) +  $cuti) >  12 ) {
                    return redirect()->back()->with('dangerss', 'Jumlah Cuti melebihi sisa batas');
                }

                foreach ($request->tanggal as $value) {
                    if ($value < $tanggal['pawal'] || $value >= $tanggal['pakhir']) {
                        return redirect()->back()->with('dangerss', 'Jadwal di luar rentang tanggal yang valid.');
                    }
                }

            } else {
                //periode depan
                $tanggal['p2awal'] = $tanggalMasuk->copy()->year($currentYear + 1)->format('Y-m-d');
                $tanggal['p2akhir'] = $tanggalMasuk->copy()->year($currentYear + 2)->format('Y-m-d');

                $cuti = CutiDetail::whereHas('cuti', function ($q) use($user) {
                    $q->where('user_cuti', $user->id)->where('status' ,'1');
                })->whereDate('tanggal_cuti', '>=', $tanggal['p2awal'])
                  ->whereDate('tanggal_cuti' ,'<=', $tanggal['p2akhir'])
                  ->where('status' ,'1')->count();

                if ((count($request->tanggal) +  $cuti) >  12) {
                    return redirect()->back()->with('dangerss', 'Jumlah Cuti melebihi sisa batas');
                }

                foreach ($request->tanggal as $value) {
                    if ($value < $tanggal['p2awal'] || $value >= $tanggal['p2akhir']) {
                        return redirect()->back()->with('dangerss', 'Jadwal di luar rentang tanggal yang valid.');
                    }
                }
            }
        }

        // PERBAIKAN: Pastikan field yang diambil sesuai dengan HTML
        if ($request->pilihan == 0) {
            $sisa = $request->sisa1;
            $pakai = $request->pakai1;
        } else {
            $sisa = $request->sisa2;  // Perhatikan: di HTML mungkin 'sisas2'
            $pakai = $request->pakai2; // Perhatikan: di HTML mungkin 'pakais2'
        }

        // Debug: Check nilai sebelum create
        \Log::info('Store Data:', [
            'user_cuti' => $request->user_cuti,
            'sisa' => $sisa,
            'pakai' => $pakai,
            'jumlah_tanggal' => count($request->tanggal),
            'sisa_akhir' => $sisa - count($request->tanggal)
        ]);

        $cuti = Cuti::create([
            'user_cuti' => $request->user_cuti,
            'user_pj' => $request->user_pj,
            'user_setuju' => $request->user_setuju,
            'user_tau' => $request->user_tau,
            'keterangan' => $request->keterangan,
            'sisa' => $sisa - count($request->tanggal),
            'dipakai' => $pakai,
            'file' => $request->file ? Storage::disk('public_uploads')->put('file_pendukung', $request->file) : null,
        ]);

        foreach ($request->tanggal as $value) {
            CutiDetail::create([
                'cuti_id' => $cuti->id,
                'tanggal_cuti' => $value,
            ]);
        }

        DB::commit();
        return redirect()->back()->with('success', 'Berhasil menambahkan cuti');

    } catch (\Throwable $th) {
        DB::rollback();
        \Log::error('Store Error: ' . $th->getMessage());
        \Log::error('Stack Trace: ' . $th->getTraceAsString());
        return redirect()->back()->with('danger', $th->getMessage());
    }
}

    public function halamanTerima($id)
    {
        $cuti = Cuti::find($id);
        if ($cuti->status != '0') {
            return redirect()->back()->with('success', 'Cuti sudah di terima');
        }
        return view('cuti.terima', compact('cuti'));
    }

    public function print($id)
    {
        $cuti = Cuti::find($id);
        if ($cuti->status != '0') {
            return redirect()->back()->with('warning', 'Cuti sudah di terima');
        }

        return view('cuti.print', compact('cuti'));
    }

    public function preview($id)
    {
        $cuti = Cuti::find($id);
        if ($cuti->status != '1') {
            return redirect()->back()->with('warning', 'Cuti belum di terima');
        }

        return view('cuti.preview', compact('cuti'));
    }

    public function terimaCuti($id, Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'file_terima' => 'nullable|mimes:pdf'
        ]);

        DB::beginTransaction();
        try {
            $cuti = Cuti::find($id);

            if ($cuti->status != '0') {
                return redirect()->back()->with('success', 'Cuti sudah di terima');
            }

            foreach ($cuti->detail as  $value) {
                $value->update([
                    'status' => '1'
                ]);
            }

            $cuti->update([
                'status' => '1',
                'file_terima' => Storage::disk('public_uploads')->put('file_terima', $request->file('file_terima'))

            ]);

            DB::commit();
            return redirect()->route('cuti.index')->with('success', 'Berhasil menerima cuti');


        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            DB::rollBack();
            return redirect()->back()->with('success', 'Gagal menerima cuti');
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
        //
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
        //
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
        try {
            $cuti = Cuti::find($id);

            if ($cuti->status != '0') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cuti sudah diterima'
                ]);
            }

            foreach ($cuti->detail as  $value) {
                $value->delete();
            }

            $cuti->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Cuti berhasil dihapus'
            ]);


        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
