<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Cashier\Purchase;

class TransactionHistoryController extends StripeTemplateController
{
    public function index (Request $request) {
      $purchases = Purchase::where('customer_id', $request->stripe_user->stripe_id)->get();

      return view()->make("purchases.index", compact("purchases"));
    }

    public function show (Request $request, Purchase $purchase) {
      $purchase->load("items.price.item");      
      return view()->make("checkout.show_invoice", compact("purchase"));
    }
}
