<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {

        //Check User enable
         if ($request->user()->state!=='ACTIVE') {
             Session::flush();
             //Auth::logout();
             return redirect('login');
             //abort(403, "No tienes autorización para ingresar.");
         }

        //Dividiendo los roles
        $array_roles = explode('|', $roles);
        foreach ($array_roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }
        abort(403, "No tienes autorización para ingresar.");

        //last
        // if (!$request->user()->hasRole($role)) {
        //     abort(403, "No tienes autorización para ingresar.");
        // }
        // return $next($request);
    }
}
