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
    public function handle($request, Closure $next, $role)
    {
        $roles = array_except(func_get_args(), [0,1]); // get array of your roles.
        if (!in_array(Auth::user()->jabatan_id, $roles) && Auth::user()->role_id != 1) {
            return redirect('home')->with('danger', 'Anda Tidak Punya Akses');
        }
        
        return $next($request);
    }
}