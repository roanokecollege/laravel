<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Blueprint::macro('RCFields', function () {
        $this->timestamp('created_at');
        $this->string('created_by', 10);
        $this->timestamp('updated_at');
        $this->string('updated_by', 10);
        $this->timestamp('deleted_at')->nullable();
        $this->string('deleted_by', 10)->nullable();
      });
    }
}
