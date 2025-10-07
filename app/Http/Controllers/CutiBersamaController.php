<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\CutiDetail;
use App\Models\Divisi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CutiBersamaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user =  User::where('status', 1)->get();

        $user = $user->groupBy(function ($item) {
            return $item->divisi->name;
        });

        $data['tau'] = User::find('52');
        $data['setuju'] = User::find('44');

        return view('cuti.bersama.create', compact('user', 'data'));
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
        $count = Cuti::where('status', '0')->count();

        if ($count > 0 ) {
           return redirect()->back()->with('dangerss', 'Pegawai masih memiliki cuti yang belum di verifikasi');
        }
        $this->validate($request, [
            'file' => 'required|mimes:pdf',
            'user_cuti' => 'required|exists:users,id',
            'user_setuju' => 'required|exists:users,id',
            'user_tau' => 'required|exists:users,id',
            'user_pj' => 'required|exists:users,id',
            'keterangan' => 'required',
            'tanggal.*' => 'required'
        ]);
        
        DB::beginTransaction();
        try {


            foreach ($request->user_cuti as $value) {

                // $user = User::find($value);
                // $tanggalMasuk = Carbon::parse($user->tgl_msk);
                // $date = $tanggalMasuk->year(date('Y'))->format('Y-m-d');

                // if ($date > Carbon::now()->format('Y-m-d')) {

                //     $tanggal['pawal'] = $tanggalMasuk->year(date('Y')-1)->format('Y-m-d');
                //     $tanggal['pakhir'] = $date;
    
                //     $pakai = CutiDetail::whereHas('cuti', function ($q) use($user) {
                //         $q->where('user_cuti', $user->id)->where('status' ,'1');
                //     })->whereDate('tanggal_cuti', '>=', $tanggal['pawal'])->whereDate('tanggal_cuti' ,'<=', $tanggal['pakhir'])->where('status' ,'1')->count();
                    
                    
                // }else{
    
                //     $tanggal['pawal'] = $date;
                //     $tanggal['pakhir'] = $tanggalMasuk->year(date('Y')+1)->format('Y-m-d');
    
                //     $pakai = CutiDetail::whereHas('cuti', function ($q) use($user) {
                //         $q->where('user_cuti', $user->id)->where('status' ,'1');
                //     })->whereDate('tanggal_cuti', '>=', $tanggal['pawal'])->whereDate('tanggal_cuti' ,'<=', $tanggal['pakhir'])->where('status' ,'1')->count();

                // }

                // $jumlahCuti = 12 - $pakai;


                $cuti = Cuti::create([
                    'user_cuti' => $value,
                    'user_pj' => $request->user_pj,
                    'user_setuju' => $request->user_setuju,
                    'user_tau' => $request->user_tau,
                    'keterangan' => $request->keterangan,
                    // 'sisa' => $jumlahCuti - count($request->tanggal),
                    // 'dipakai' => $pakai,
                    'sisa' => null,
                    'dipakai' => null,
                    'file_terima' => Storage::disk('public_uploads')->put('file', $request->file),
                    'status' => '1'
                ]);
    
                foreach ($request->tanggal as $value1) {
                    CutiDetail::create([
                        'cuti_id' => $cuti->id,
                        'tanggal_cuti' => $value1,
                        'status' => '1'
                    ]);
                }
            }



            DB::commit();
            return redirect()->back()->with('success', 'Berhasil menambahkan cuti bersama');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            dd($th);
            return redirect()->back()->with('danger', $th->getMessage());
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
        //
    }
}
