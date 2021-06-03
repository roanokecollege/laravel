<?php
  use \Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("login", function (Request $request) {
  $returnURL = Session::get("returnURL", $request->url() . "/../");
  return RCAuth::redirectToLogin($returnURL);
});

Route::get("logout", function (Request $request) {
  RCAuth::logout();
  $returnURL = $request->url() . "/../";
  return RCAuth::redirectToLogout($returnURL);
});

Route::middleware("force_login")->group(function () {
  Route::get('/', function () {
      return view('welcome');
  })->name("home");

  Route::get('/billing-portal', function (Request $request) {
      return $request->stripe_user->redirectToBillingPortal(action("CashierController@index"));
  })->name("billing_portal");

  Route::get("items",                   "CashierController@index");
  Route::get("purchase/{stripe_item}",  "CashierController@showItemCheckout");
  Route::post("checkout/{stripe_item}", "CashierController@getUpdatedCheckoutButton");
  Route::get ("checkout/success",       "CashierController@displayInvoice");

  Route::prefix("cart")->group(function () {
    Route::post("/add",      "CashierController@addToCart");
    Route::post("/remove",   "CashierController@removeFromCart");
    Route::post("/clear",    "CashierController@clearCart");
    Route::post("/checkout", "CashierController@redirectToCheckout");
  });

  Route::prefix('purchases')->group(function () {
    Route::get("/",           "TransactionHistoryController@index");
    Route::get("/{purchase}", "TransactionHistoryController@show");
  });

  Route::prefix("admin")->middleware("force_cashier_admin")->group(function () {
    Route::get ("/",       "Admin\ProductController@index");
    Route::get ("/create", "Admin\ProductController@create");
    Route::post("/create", "Admin\ProductController@store");
    Route::prefix("{item}")->group(function () {
      Route::get   ("/",     "Admin\ProductController@show");
      Route::delete("/",     "Admin\ProductController@destroy");
      Route::get   ("/edit", "Admin\ProductController@edit");
      Route::put   ("/",     "Admin\ProductController@update");
      Route::prefix("/price")->group(function () {
        Route::post   ("/add",    "Admin\ProductController@addPrice");
        Route::delete ("/remove/{price}", "Admin\ProductController@removePrice");
      });
    });
  });
});
