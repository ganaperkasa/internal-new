<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Auth;
use App\Models\UserRole;

class Firewalls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path      = $request->route()->uri();
        // if(is_null(Auth::user()->role_active) || is_null(Auth::user()->location_active)){
        //     $location = Auth::user()->location->first();
        //     $user = Auth::user();
        //     $user->setLocationActive($location->code);
        //     $user->save();
        //
        //     $role = UserRole::where('location_id', $location->code)->first();
        //     $user->setRoleActive($role->role_id);
        //     $user->save();
        // }
        // // dump(Auth::user()->getPermission());
        // $hak_akses = Role::find(Auth::user()->role_active)->permissions;
        // if($hak_akses->contains('url',$path)){
            return $next($request);
        // }
        // return redirect('/home')->with('status', 'Tidak punya akses '.$path.', silakan hubungi administrator');

    }
}
