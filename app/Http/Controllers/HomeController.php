<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RCAuth;

use App\Models\User;

class HomeController extends Controller
{

    public function __construct()
    {
        $this::middleware(function ($request, $next) {
            $side_navigation = [
                                '<span class="far fa-fw fa-home"></span> Home' => action([self::class, 'index']),
                               ];

            if (RCAuth::check() || RCAuth::attempt()) {
                $side_navigation['<i class="far fa-fw fa-sign-out"></i> Logout ' . RCAuth::user()->username] = route('logout');
            } else {
                $side_navigation['<i class="far fa-fw fa-sign-out"></i> Login'] = route('login');
            }

            view()->share('side_navigation', $side_navigation);

            return $next($request);
        });
    }

    public function index()
    {
        return view('index');
    }
}
