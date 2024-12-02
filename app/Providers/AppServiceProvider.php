<?php

namespace App\Providers;

use App\Models\Bidang;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $bidangs = Bidang::with('subBidangs')->get();

        view()->share('bidangs', $bidangs);
    }
}
