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

      $side_navigation = [
        "<span class='far fa-home'></span> Home" => action("CashierController@index"),
        "<span class='fab fa-stripe-s'></span> Stripe Dashboard" => route("billing_portal")
      ];

      view()->share("side_navigation", $side_navigation);
    }

    public function index () {
      $items = Items::orderBy("product_name")->get();
      return view()->make("products.index", compact("items"));
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

    private function renderShoppingCart (Request $request) {
      $items = $request->session()->get("cart");

      $cart  = \App\Cashier\Prices::whereIn("price_id", $items->keys())
                                  ->get()
                                  ->map(function ($item) use ($items) {
                                      $item->quantity = $items[$item->price_id]["quantity"];
                                      return $item;
                                    });

      return response()->json(["data" => view()->make("partials.actual_cart", ["cart_items" => $cart])->render()]);
    }

    public function addToCart (Request $request) {
      $cart = $request->session()->pull("cart");
      $cart[$request->item['price_id']] = $request->item;
      $request->session()->put("cart", $cart);

      return $this->renderShoppingCart($request);
    }

    public function removeFromCart (Request $request) {
      $cart = $request->session()->pull("cart");
      $cart->forget($request->index);
      $request->session()->put("cart", $cart);

      return $this->renderShoppingCart($request);
    }

    public function clearCart (Request $request) {
      $request->session()->put("cart", collect());

      return $this->renderShoppingCart($request);
    }

    public function redirectToCheckout (Request $request) {
      $line_items = $request->session()->get("cart")->map(function ($item) {
        return ["price" => $item['price_id'], "quantity" => $item["quantity"]];
      });

      $session = $request->stripe->checkout->sessions->create([
        'customer'             => $request->stripe_user->stripe_id,
        'mode'                 => 'payment',
        'payment_method_types' => ['card'],
        'line_items'           => $line_items->values()->all(),
        'success_url'          => action("CashierController@displayInvoice") . "?session_id={CHECKOUT_SESSION_ID}",
        'cancel_url'           => action("CashierController@index")
      ]);

      return view()->make("checkout.redirect", ['sessionId' => $session->id]);//$request->stripe->redirectToCheckout(['sessionId' => $session->id]);
    }

    //
    public function displayInvoice (Request $request) {
      $session  = $request->stripe->checkout->sessions->retrieve($request->get('session_id'));
      $customer = $request->stripe->customers->retrieve($session->customer);
      $payment  = $request->stripe->paymentIntents->retrieve($session->payment_intent);
      $charge   = $payment->charges->first(); // We are not doing subscriptions, so there's no need to worry about multiple charges
      $purchased_items = $request->session()->get("cart"); //TODO: Change to pull

      $purchase = new \App\Cashier\Purchase;
      $purchase->populateAttributes($session->customer, $session->payment_intent, $charge->id, $charge->amount,
                                    $charge->receipt_url, $request->stripe_user->rcid);
      $purchase->save();

      $items = collect();
      foreach($purchased_items as $item) {
        $purchased_item = new \App\Cashier\PurchaseItem;
        $purchased_item->populateAttributes($purchase->id, $item['price_id'], $item['quantity'],
                                             $request->stripe_user->rcid);
        $purchased_item->save();
      }
      $purchase->load("items.price.item");
      return view()->make("checkout.show_invoice", compact("session", "customer", "purchase", "purchased_items"));
    }
}
