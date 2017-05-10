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

Route::get('/cadastro', function () {
    // TODO: criar layout da página
})->name('home');

Route::get('/quero-vender', function () {
    // TODO: criar layout da página
})->name('home');

Route::get('/sobre', function () {
    // TODO: criar layout da página
})->name('home');

Route::get('/como-funciona', function () {
    // TODO: criar layout da página
})->name('home');

Route::get('/contato', function () {
    // TODO: criar layout da página
})->name('home');

Route::group(['prefix'=>'auth'], function () {
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
    Route::get('/register', 'UserController@registerGet')->name('register');
    Route::post('/register', 'UserController@registerPost')->name('registerPost');

    // Resete de senha
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');
});


Route::get('/me/profile', function() {
    return 'Formulário de edição de perfil do usuário logado';
})->name('profile');

Route::post('/me/profile', function() {
    return 'Aqui salvamos os dados vindos do formulário de edição do perfil';
})->name('profileSave');

Route::get('/painel/{vue?}', function () {
    return view('admin');
})->where('vue', '[\/\w\.-]*')->name('dashboard');