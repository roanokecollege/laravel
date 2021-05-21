<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Cashier\Items;

use Stripe;

class CashierController extends Controller
{

    public function __construct (Request $request) {
      $this->stripe_user = $request->stripe_user;
      $this->stripe      = $request->stripe;
    }

    public function showItemCheckout (Request $request, Items $stripe_item) {
      $stripe_item->load("prices");
      $stripe_user = $request->stripe_user;

      return view()->make("purchase", compact("stripe_item", "stripe_user"));
    }

    public function getUpdatedCheckoutButton (Request $request, Items $stripe_item) {
      $request->validate(["quantity" => "required|numeric", "price_id" => "required"]);
      $checkout = $request->stripe_user->checkout([ $request->price_id => $request->quantity]);

      return $checkout->button("Purchase");
    }

    //
    public function generateInvoice () {

    }
}
