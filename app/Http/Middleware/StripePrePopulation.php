<?php

namespace App\Http\Middleware;

use Closure;

class StripePrePopulation
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
      $stripe = new \Stripe\StripeClient(
        env("STRIPE_SECRET")
      );
      $request->merge(["stripe" => $stripe]);

      return $next($request);
    }
}
