<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Services Routes
|--------------------------------------------------------------------------
|
*/
Route::group(['prefix' => 'moip'], function() {
    Route::group(['prefix' => 'marketplace'], function() {
        Route::get('authorize', 'Api\Auth\MoipController@authorizeSellerAndGetCode');
        Route::get('refresh', 'Api\Auth\MoipController@refreshSellerAndUpdate');
        Route::get('callback', 'Api\Auth\MoipController@sellerGetCredentials');
        Route::get('keys', 'Api\Auth\MoipController@getPublicKey');
        /**
         | Process checkout
         */
        Route::post('order/process', 'Moip\CheckoutController@process');
    });
    /**
     *
     */
    Route::group(['prefix' => 'services'], function() {
        Route::get('orders', 'Moip\CustomerOrderController@allOrders');
        /**
        * Cart
        */
        Route::group(['prefix' => 'cart', 'namespace' => 'Moip'], function() {
            Route::get('/', 'CartController@index');
            Route::post('/', 'CartController@addItemToCart');
            Route::put('{index}', 'CartController@update');
            Route::post('address', 'CartController@addAddress');
            Route::get('address', 'CartController@getAddress');
        });
        Route::post('coupon-verify', 'Api\Admin\V1\System\CouponController@verify');
    });

    /**
     * Redirects.
     */
    Route::group(['prefix' => 'payments', 'as' => 'moip.payments.'], function() {
        Route::get('success', 'Moip\CheckoutController@paymentSuccess')->name('success');
        Route::get('error', 'Moip\CheckoutController@paymentError')->name('error');
    });
});

Route::group(['prefix' => 'services/cardapio'], function(){
    Route::get('categories', 'Api\Admin\V1\System\CategoryController@index');
});

Route::get('user-is-logged-in', function(\Illuminate\Http\Request $request) {
    return \App\Support\Auth\UserIsLogged::run($request);
});


/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
*/

Route::get('send_test_email', function(){
    Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
    {
        $message->to('michel@nitdesign.com.br');
    });
});

/**
 | Default Routes
 */
Route::group(['prefix' => '/'], function() {
    // Route::get('/home', function () { return view('home'); })->name('home');
    Route::get('/', function () { return view('maintenance'); })->name('home');
    Route::get('entrar', function () { return view('entrar'); })->name('entrar');
    // Route::get('quero-vender', 'UserController@sellerRegister')->name('queroVender');
    // Route::post('quero-vender', 'UserController@sellerRegisterPost')->name('queroVenderPost');
    // Route::get('sobre', function () { return view('sobre'); })->name('sobre');
    // Route::get('como-funciona', function () { return view('como-funciona');})->name('comoFunciona');
    // Route::get('contato', function () { return view('contato');})->name('contato');
    // Route::get('termos-condicoes', function () { return view('termos-condicoes'); })->name('termos');
    // Route::get('privacidade', function () { return view('privacidade'); })->name('privacidade');
    // Route::post('contato', 'FrontendController@contatoPost')->name('contatoPost');
});

Route::group(['prefix'=>'entrar'], function () {
    // Home da sessão autenticação
    Route::get('/', function(){ return view('user.index'); })->name('authHome')->middleware(\App\Http\Middleware\RedirectUser::class);

    // Login
    Route::post('login', 'UserController@login')->name('login');
    Route::get('logout', 'UserController@logout')->name('logout');

    // Validate
    Route::post('check-email', 'UserController@checkEmail')->name('checkEmail');
    Route::post('check-cpf', 'UserController@checkCpf')->name('checkCpf');

    // Facebook auth
    Route::get('social/redirect/{provider}', 'SocialAuthController@redirect')->name('facebookAuth');
    Route::get('social/callback/{provider}', 'SocialAuthController@callback');

    // Cadastro de usuário
    Route::post('register', 'UserController@registerPost')->name('registerPost');

    // Reset de senha
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::group(['prefix'=>'minha-conta', 'middleware' => ['auth']], function () {
    Route::get('get-addresses', 'MeController@getAddressesByUserId')->name('get-addresses');
    Route::delete('enderecos/{id}', 'MeController@destroyAddress')->name('destroy-address');
    Route::post('save-address', 'MeController@addressesPost')->name('save-address');
    Route::patch('enderecos/{id}', 'MeController@updateAddrDefault');
    /**
    | Profile
    */
    Route::get('enderecos', 'MeController@addresses')->name('profile.adresses');
    Route::get('minhas-avaliacoes', 'MeController@score')->name('profile.score');
    Route::get('perfil', 'MeController@profile')->name('profile');
    Route::post('perfil', 'MeController@profilePost')->name('profile.post');
    Route::post('troca-senha', 'MeController@passwordPost')->name('profile.password');
    Route::post('troca-avatar', 'MeController@avatarPost')->name('profile.avatar');
    /**
     | My orders
    */
    Route::get('pedidos', 'Moip\CustomerOrderController@index')->name('orders.list');
    Route::get('pedidos/{id}', 'Moip\CustomerOrderController@show')->name('orders.show');
    /**
     | Action Profile
    */
    Route::post('me/profile', function() { return 'update profile'; })->name('profileSave');
});


// Route::get('/lista-chefs/{cep?}', 'FrontendController@index')->name('lista-chefs-page');

Route::get('/lista-chefs/{latitude?}/{longitude?}', 'FrontendController@index')->name('lista-chefs-page');
Route::get('/get-chefs', 'FrontendController@listChefs')->name('get-chefs');
Route::post('/lista-chefs/{latitude?}/{longitude?}', 'FrontendController@listChefsByCep')->name('get-chefs-by-cep');
Route::get('/get-products/{id}/{day?}', 'FrontendController@listProducts')->name('get-products');
Route::get('/chefs/{id}/{city?}/{slug?}', 'FrontendController@singleChef')->name('single-chef');
Route::get('/painel/{vue?}', function () { return view('admin'); })->where('vue', '[\/\w\.-]*')->name('dashboard');
