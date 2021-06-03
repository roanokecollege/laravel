<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cashier\Items;
use App\ParkingDecals;

class ParkingDecalController extends Controller
{
    public function __construct (Request $request) {
      $this->middleware("parking_decals");
    }

    public function showForm (\App\User $user, Items $item) {
      $states = \App\States::orderBy("StateCode")->get();
      return view()->make("campus_safety.decal_form", compact("user", "item", "states"));
    }

    public function storeRequest (Request $request, \App\User $user, Items $item) {
      $request->validate([
        'resident' => 'required|boolean',
        'make'     => 'required|string|max:255',
        'model'    => 'required|string|max:255',
        'color'    => 'required|string|max:255',
        'year'     => 'required|numeric|min:1900',
        'plate'    => 'required|string',
        'state'    => 'required|string|size:2'
      ]);

      $decal_request = new ParkingDecals;
      $decal_request->populateAttributes($request, $user);
      $decal_request->save();

      $session = $request->stripe->checkout->sessions->create([
        'customer'             => $request->stripe_user->stripe_id,
        'mode'                 => 'payment',
        'payment_method_types' => ['card'],
        'line_items'           => [
          [
            'price' => $item->prices->first()->price_id,
            'quantity' => 1
          ]
        ],
        'success_url'          => action("ParkingDecalController@successfulPayment") . "?session_id={CHECKOUT_SESSION_ID}",
        'cancel_url'           => action("ParkingDecalController@cancelledPayment") . "?session_id={CHECKOUT_SESSION_ID}",
        'metadata'             => ["decalId" => $decal_request->id]
      ]);

      return view()->make("checkout.redirect", ['sessionId' => $session->id]);
    }

    public function successfulPayment (Request $request, \App\User $user, Items $item) {
      CashierController::storePurchase($request, $session, $purchase);

      $decal_request = ParkingDecals::find($session->metadata['decalId']);
      $decal_request->fkey_purchase_id = $purchase->id;
      $decal_request->paid             = true;
      $decal_request->save();

      $purchase_item = new \App\Cashier\PurchaseItem;
      $purchase_item->populateAttributes ($purchase->id, $item->prices->first()->price_id, 1, $request->stripe_user->rcid);
      $purchase_item->save();

      \App\Email::sendEmail($request->user->CampusEmail, 'campussafety@roanoke.edu',
                            'Parking Decal Request Received',
                            view()->make("campus_safety.emails.decal_confirm", compact("decal_request", "user", "purchase"))->render());

      return redirect()->action("TransactionHistoryController@show", $purchase);
    }
}
