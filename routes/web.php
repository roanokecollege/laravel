<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, SearchController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Login route
 */
Route::get('login', function() {
  $returnURL = Session::get('returnURL', Request::url() . '/../');

  return RCAuth::redirectToLogin($returnURL);
})->name('login');

/**
* Logout route
*/
Route::get('logout', function() {
  RCAuth::logout();
  $returnURL = Request::url() . '/../';
  return RCAuth::redirectToLogout($returnURL);
})->name('logout');

/**
 * Home route
 */
Route::middleware("force_login")->get('/', [HomeController::class, 'index']);

/**
 * Mustang Typeahead Search route
 */
Route::get('/search', [SearchController::class, 'typeahead']);
