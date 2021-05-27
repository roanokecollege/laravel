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

      if (!$request->session()->has("cart")) {
        $request->session()->put("cart", collect());
      }

      $items = $request->session()->get("cart");

      $cart  = \App\Cashier\Prices::whereIn("price_id", $items->keys())
                                  ->get()
                                  ->map(function ($item) use ($items) {
                                      $item->quantity = $items[$item->price_id]["quantity"];
                                      return $item;
                                    });

      view()->share("cart_items", $cart);
      view()->share("stripe_checkout_route", action("CashierController@redirectToCheckout"));

      return $next($request);
    }
}
