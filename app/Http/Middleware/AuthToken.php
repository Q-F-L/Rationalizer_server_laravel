<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // die($request->bearerToken());$_SERVER['HTTP_AUTHORIZATION']
        $user =  User::where('remember_token', $request->bearerToken())->first();
        // print_r( $request->bearerToken() == $user->remember_token );exit;

        if($request->bearerToken() === $user->remember_token)
            return $next($request);
        else
            return route('login');
    }
}
