<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class CheckUserRole
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
        // return $next($request);
        // $user = \App\User::findOrFail(2);
        // $user = Auth::user();
        // dd($user);
        if (Auth::check() && Auth::user()->role_id === 2) {
            return $next($request);
        } else {
            return abort(401);
        }
    }
}
