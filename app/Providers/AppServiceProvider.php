<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Wallet;
use App\Observers\WalletObserver;

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
        Wallet::observe(WalletObserver::class);
    }
}
