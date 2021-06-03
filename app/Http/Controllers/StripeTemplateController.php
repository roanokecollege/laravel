<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeTemplateController extends Controller
{
  public function __construct (Request $request) {
    $this->stripe_user = $request->stripe_user;
    $this->stripe      = $request->stripe;

    $side_navigation = [
      "<span class='far fa-fw fa-home'></span> Home" => action("CashierController@index"),
      "<span class='fas fa-fw fa-file-invoice'></span> Purchases" => action("TransactionHistoryController@index"),
      "<span class='fab fa-fw fa-stripe-s'></span> Stripe Dashboard" => route("billing_portal"),
    ];

    view()->share("side_navigation", $side_navigation);
  }
}
