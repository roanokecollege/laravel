<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use RCAuth;
use App\User;
use App\StripeUser;

class ForceLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $returnRoute = Redirect::to("login")->with("returnURL", $request->fullUrl());

      if (RCAuth::check() || RCAuth::attempt()) {
        $rcid        = RCAuth::user()->rcid;
        $user        = User::where("RCID", $rcid)->first();
        $stripe_user = StripeUser::find($rcid);

        if (empty($stripe_user)) {
          $stripe_user = new StripeUser;
          $stripe_user->rcid       = $rcid;
          $stripe_user->created_by = $rcid;
          $stripe_user->updated_by = $rcid;
          $stripe_user->save();
          $stripe_user->createAsStripeCustomer();
        }

        if (!empty($user)) {
          app()->instance(\App\User::class, $user);
          $request->merge(['user' => $user]);
          $request->setUserResolver(function () use ($user) {
            return $user;
          });
          $request->merge(['stripe_user' => $stripe_user]);

          $returnRoute = $next($request);
        }
      }

      return $returnRoute;
    }
}
