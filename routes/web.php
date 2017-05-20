<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
*/

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

Route::post('/contato', 'FrontendController@contatoPost')->name('contatoPost');

Route::group(['prefix'=>'entrar'], function () {
    // Home da sessão autenticação
    Route::get('/', function() {
       return view('user.index');
    })->name('authHome');

    // Login
    Route::post('/login', 'UserController@login')->name('login');
    Route::get('/logout', 'UserController@logout')->name('logout');

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

    Route::get('/minhas-avaliacoes', 'MeController@score')->name('profileS.score');

    Route::get('/perfil', 'MeController@profile')->name('profile');
    Route::post('/perfil', 'MeController@profilePost')->name('profile.post');
    Route::post('/troca-senha', 'MeController@passwordPost')->name('profile.password');
    Route::post('/troca-avatar', 'MeController@avatarPost')->name('profile.avatar');
});

Route::post('/me/profile', function() {
    return 'Aqui salvamos os dados vindos do formulário de edição do perfil';
})->name('profileSave');

Route::get('/painel/{vue?}', function () {
    return view('admin');
})->where('vue', '[\/\w\.-]*')->name('dashboard');