<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\CutiDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $data = [];

        // Query Helper Function
        $baseQuery = "
            SELECT s.*, u.name AS created, m.name AS marketing,
                   i.name AS instansi, t.name AS type
            FROM adm_project s
            INNER JOIN m_instansi i ON i.id = s.instansi_id
            INNER JOIN m_type_project t ON t.id = s.type_project_id
            INNER JOIN users u ON u.id = s.created_by
            INNER JOIN users m ON m.id = s.marketing_id
            WHERE s.status = 1
              AND s.progress <> 100
              AND t.name = ?
            ORDER BY s.end ASC
        ";

        $data['pekerjaan_software'] = DB::select($baseQuery, ['Software']);
        $data['pekerjaan_hardware'] = DB::select($baseQuery, ['Hardware']);
        $data['maintenance_software'] = DB::select($baseQuery, ['Maintenance Software']);
        $data['maintenance_hardware'] = DB::select($baseQuery, ['Maintenance Hardware']);
        $data['pekerjaan_lainnya'] = DB::select($baseQuery, ['Jasa Lainnya']);

        $data['daily'] = DB::select("
            SELECT a.*, u.name
            FROM agendas a
            INNER JOIN users u ON u.id = a.user_by
            WHERE a.status = 1
            ORDER BY a.tanggal DESC
            LIMIT 50
        ");

        $cuti = CutiDetail::where('status', '1')
            ->where('tanggal_cuti', '>=', Carbon::today())
            ->get()
            ->groupBy('tanggal_cuti');

        $data['cuti'] = $cuti;

        return view('home', $data);
    }

    public function profile()
    {
        $data['data_edit'] = auth()->user();
        return view('profile', $data);
    }

    public function profileUpdate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:200',
            'email' => 'required|email|max:150',
            'password' => 'nullable|confirmed|min:6',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail(auth()->id());
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }

            $user->save();

            DB::commit();

            return redirect()->route('profil')->with('success', 'Berhasil merubah profil');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('danger', 'Data gagal diubah: ' . $e->getMessage());
        }
    }
}
