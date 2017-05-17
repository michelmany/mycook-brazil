<?php

namespace App\Providers;

use App\FotoEstabelecimento;
use App\Observables\FotoEstabelecimentoObservable;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);
        FotoEstabelecimento::observe(FotoEstabelecimentoObservable::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
