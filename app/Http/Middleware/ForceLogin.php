<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use RCAuth;
use \App\Models\User;

class ForceLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next) {
        $return_route = redirect()->to('login')->with('returnURL', $request->fullUrl());
        
        if ((RCAuth::check() || RCAuth::attempt())) {
            $rcid = RCAuth::user()->rcid;
            $user = User::where('RCID', $rcid)->first();

            if (!empty($user)) {
                $return_route = $next($request);
            }
        }

        return $return_route;
    }
}
