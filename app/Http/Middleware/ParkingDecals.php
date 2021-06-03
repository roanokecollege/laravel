<?php

namespace App\Http\Middleware;

use \App\Cashier\Items;
use Closure;

class ParkingDecals
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
        $item = Items::find(1);
        app()->instance(\App\Cashier\Items::class, $item);
        return $next($request);
    }
}
