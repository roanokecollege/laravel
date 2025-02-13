<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/**
 * Login route
 */
Route::get('login', function() {
    $return_url = Session::get('returnURL', Request::url() . '/../');

    return RCAuth::redirectToLogin($return_url);
})->name('login');

/**
* Logout route
*/
Route::get('logout', function() {
    RCAuth::logout();
    $return_url = Request::url() . '/../';
    return RCAuth::redirectToLogout($return_url);
})->name('logout');


/**
 * Sample routes
 */
Route::middleware(\App\Http\Middleware\ForceLogin::class)->group(function () {
    Route::get ('/', [Controllers\HomeController::class, 'index']);
    Route::get ('/search', [Controllers\SearchController::class, 'typeahead']);
});
