<?php

namespace App\Providers;

use App\Models\FotoEstabelecimento;
use App\Models\Moip\MoipSeller;
use App\Models\Product;

use App\Observers\FotoEstabelecimentoObservable;
use App\Observers\MoipSellersObservable;
use App\Observers\ProductsObservable;
use App\Observers\UsersObservable;
use App\User;
use Illuminate\Support\ServiceProvider;
use Moip\Auth\OAuth;
use Moip\Moip;

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
        Product::observe(ProductsObservable::class);
        /**
         |
         |
         */
        \View::composer('user.index', function($view) {
            $request = request();
            $view->with('intended', $request->get('intended') ?? '');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MoipAuthService::class, function($app) {
            $accessToken = auth()->user()->moipseller->data['accessToken'];
            $endpoint = config('moip.homologated');
            return new MoipAuthService(
                new Moip( new OAuth( $accessToken ), ($endpoint ?: Moip::ENDPOINT_SANDBOX)),
                $app->make('request')
            );
        });
    }
}
