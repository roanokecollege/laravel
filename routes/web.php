<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;

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

/**
 * Login route
 */
Route::get('login', function () {
    $return_url = Session::get('returnURL', Request::url() . '/../');

    return RCAuth::redirectToLogin($return_url);
})->name('login');

/**
 * Logout route
 */
Route::get('logout', function () {
    RCAuth::logout();
    $return_url = Request::url() . '/../';
    return RCAuth::redirectToLogout($return_url);
})->name('logout');

/**
 * Home route
 */
Route::get('/', [HomeController::class, 'index']);

/**
 * Mustang Typeahead Search route
 */
Route::get('/search', [SearchController::class, 'typeahead']);
