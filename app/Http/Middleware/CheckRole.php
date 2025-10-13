<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {

        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($user->role_id == 1) {
            return $next($request);
        }

        if (!in_array($user->jabatan_id, $roles)) {
            return redirect()->route('home')->with('danger', 'Anda Tidak Punya Akses');
        }

        return $next($request);
    }
}
