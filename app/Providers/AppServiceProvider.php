<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pasien;
use App\Observers\PasienObserver;
use App\Models\AhliGizi;
use App\Observers\AhliGiziObserver;
use App\Models\Chef;
use App\Observers\ChefObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
      public function boot()
    {
        Pasien::observe(PasienObserver::class);
        AhliGizi::observe(AhliGiziObserver::class);
        Chef::observe(ChefObserver::class);
    }
}
