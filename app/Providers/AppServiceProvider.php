<?php

namespace App\Providers;

use App\FotoEstabelecimento;
use App\Models\Moip\MoipSeller;
use App\Observables\FotoEstabelecimentoObservable;
use App\Observables\MoipSellersObservable;
use App\Observables\UsersObservable;
use App\User;
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
        User::observe(UsersObservable::class);
        MoipSeller::observe(MoipSellersObservable::class);
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
