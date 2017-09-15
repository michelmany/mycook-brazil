<?php
/*
|--------------------------------------------------------------------------
| Services Routes
|--------------------------------------------------------------------------
|
*/
Route::group(['prefix' => 'moip/marketplace', 'middleware' => 'auth'], function() {
    Route::get('authorize', 'Api\Auth\MoipController@authorizeSellerAndGetCode');
    Route::get('refresh', 'Api\Auth\MoipController@refreshSellerAndUpdate');
    Route::get('callback', 'Api\Auth\MoipController@sellerGetCredentials');
    Route::get('keys', 'Api\Auth\MoipController@getPublicKey');
    /**
     *
     */
    Route::group(['prefix' => 'services'], function() {
        Route::get('customer', 'Moip\MoipCustomerController@store');
        Route::get('customer/{id}', 'Moip\MoipCustomerController@show');
        Route::get('order', 'Moip\MoipOrderController@store');
    });
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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/entrar', function () {
    return view('entrar');
})->name('entrar');

Route::get('/quero-vender', 'UserController@sellerRegister')->name('queroVender');
Route::post('/quero-vender', 'UserController@sellerRegisterPost')->name('queroVenderPost');


Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');

Route::get('/como-funciona', function () {
    return view('como-funciona');
})->name('comoFunciona');

Route::get('/contato', function () {
    return view('contato');
})->name('contato');

Route::get('/termos-condicoes', function () {
    return view('termos-condicoes');
})->name('termos');

Route::get('/privacidade', function () {
    return view('privacidade');
})->name('privacidade');

Route::post('/contato', 'FrontendController@contatoPost')->name('contatoPost');

Route::group(['prefix'=>'entrar'], function () {
    // Home da sessão autenticação
    Route::get('/', function() {
        $user = Auth::user();
        if ($user) {
            $user = Auth::user();
            if (!$user->addresses->first()) {
                return redirect()->to('/minha-conta/enderecos');
            }
            return redirect()->to('/lista-chefs');
        }
       return view('user.index');
    })->name('authHome');

    // Login
    Route::post('/login', 'UserController@login')->name('login');
    Route::get('/logout', 'UserController@logout')->name('logout');

    // Validate
    Route::post('/check-email', 'UserController@checkEmail')->name('checkEmail');
    Route::post('/check-cpf', 'UserController@checkCpf')->name('checkCpf');

    // Facebook auth
    Route::get('/social/redirect/{provider}', 'SocialAuthController@redirect')->name('facebookAuth');
    Route::get('/social/callback/{provider}', 'SocialAuthController@callback');

    // Cadastro de usuário
    Route::post('/register', 'UserController@registerPost')->name('registerPost');

    // Resete de senha
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::group(['prefix'=>'minha-conta', 'middleware' => ['auth']], function () {
    Route::get('/enderecos', 'MeController@addresses')->name('profile.adresses');
    Route::get('/get-addresses', 'MeController@getAddressesByUserId')->name('get-addresses');
    Route::delete('/enderecos/{id}', 'MeController@destroyAddress')->name('destroy-address');
    Route::post('/save-address', 'MeController@addressesPost')->name('save-address');

    Route::get('/minhas-avaliacoes', 'MeController@score')->name('profile.score');

    Route::get('/perfil', 'MeController@profile')->name('profile');
    Route::post('/perfil', 'MeController@profilePost')->name('profile.post');
    Route::post('/troca-senha', 'MeController@passwordPost')->name('profile.password');
    Route::post('/troca-avatar', 'MeController@avatarPost')->name('profile.avatar');
});

Route::post('/me/profile', function() {
    return 'Aqui salvamos os dados vindos do formulário de edição do perfil';
})->name('profileSave');

// Open the lista-chefs page
// Route::get('/lista-chefs/{cep?}', 'FrontendController@index')->name('lista-chefs-page');
Route::get('/lista-chefs/{latitude?}/{longitude?}', 'FrontendController@index')->name('lista-chefs-page');
// Get the chefs list by vue axios
Route::get('/get-chefs', 'FrontendController@listChefs')->name('get-chefs');
//Get chefs by cep
Route::post('/lista-chefs/{latitude?}/{longitude?}', 'FrontendController@listChefsByCep')->name('get-chefs-by-cep');

// get products
Route::get('/get-products/{id}/{day?}', 'FrontendController@listProducts')->name('get-products');
// Route::get('/get-filtered-products/{id}', 'FrontendController@listProducts')->name('get-products');

Route::group(['prefix'=>'chefs'], function () {
    Route::get('{id}/{city?}/{slug?}', 'FrontendController@singleChef')->name('single-chef');
});

Route::get('/painel/{vue?}', function () {
    return view('admin');
})->where('vue', '[\/\w\.-]*')->name('dashboard');