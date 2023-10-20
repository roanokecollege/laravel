<?php

namespace App\Http\Middleware;

use Closure;
use RCAuth;
use Redirect;

use App\Models\User;

class ForceLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $return_route = Redirect::to('login')->with('returnURL', $request->fullUrl());
        
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
