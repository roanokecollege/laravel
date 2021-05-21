<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Cashier\Items;

class ProductController extends Controller
{
    public function __construct() {
      $side_navigation = [
        "<span class='far fa-home'></span> Home" => "https://www.roanoke.edu",
        "<span class='far fa-home'></span> Admin Home" => action ("Admin\ProductController@index"),
      ];

      view()->share("side_navigation", $side_navigation);
    }

    public function index () {
      $items = Items::orderBy("product_name")->get();
      return view()->make("admin.products.index", compact("items"));
    }

    public function create () {
      return view()->make("admin.products.create_edit");
    }

    public function store (Request $request) {
      $request->validate(["product_name" => "required", "object_code" => "required"]);

      $response = $request->stripe->products->create(["name" => $request->product_name, "metadata" => ["Object Code" => $request->object_code]]);

      $product = new Items;
      $product->product_name = $request->product_name;
      $product->product_id   = $response->id;
      $product->object_code  = $response->object_code;
      $product->created_by   = $product->updated_by = \RCAuth::user()->rcid;
      $product->save();

      return redirect()->action("Admin\ProductController@index")->with("success", "Successfully stored new product.");
    }

    public function show (Items $item) {
      $item->load("prices");
      return view()->make("admin.products.show", compact("item"));
    }

    public function edit (Items $item) {
      return view()->make("admin.products.create_edit", compact("item"));
    }

    public function update (Request $request, Items $item) {
      return redirect()->action("Admin\ProductController@index")->with("success", "Successfully updated product.");
    }

    public function destroy (Items $item) {
      return redirect()->action("Admin\ProductController@index")->with("danger", "Successfully deleted product.");
    }

    // AJAX METHODS
    public function addPrice (Request $request, Items $item) {
      $request->validate([
        "price" => "required|numeric",
        "name"  => "required"
      ]);

      //Add to Stripe
      $response = $request->stripe->prices->create([
        "unit_amount" => ($request->price * 100),
        "currency"    => "usd",
        "product"     => $item->product_id,
        "metadata"    => ["name" => $request->name, "object_code" => $item->object_code]
      ]);

      //Add Locally
      $price = new Prices;
      $price->fkey_product_id = $item->id;
      $price->price_id        = $response->id;
      $price->name            = $request->name;
      $price->created_by      = $price->updated_by = \RCAuth::user()->rcid;
      $price->save();

      //Return display entry for show page
      return response()->json(["display" => view()->make("admin.products.partials.price_display", compact("price"))->render()]);
    }

    public function removePrice (Items $item, Prices $price) {
      //Set inactive on Stripe
      $request->stripe->prices->update($item->price_id, ["active" => false]);

      //Soft delete locally
      $price->deleted_by = $price->updated_by = \RCAuth::user()->rcid;
      $price->save();
      $price->delete();
    }
}
