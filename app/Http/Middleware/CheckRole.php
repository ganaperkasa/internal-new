<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
         $user = Auth::user();

        // Kalau belum login
        if (!$user) {
            return redirect('login');
        }

        // Kalau role_id = 1 (Superadmin) → akses semua
        if ($user->role_id == 1) {
            return $next($request);
        }

        // Cek berdasarkan nama role (misalnya: 'Admin', 'Staf')
        if (! in_array($user->role_id, $roles)) {
            return redirect('home')->with('danger', 'Anda Tidak Punya Akses');
        }

        return $next($request);
    }
}
