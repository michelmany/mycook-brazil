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

Route::get('/auth/social/redirect/{provider}', 'SocialAuthController@redirect');
Route::get('/auth/social/callback/{provider}', 'SocialAuthController@callback');

Route::get('/me/profile', function() {
    return 'Formulário de edição de perfil do usuário logado';
})->name('profile');

Route::post('/me/profile', function() {
    return 'Aqui salvamos os dados vindos do formulário de edição do perfil';
})->name('profileSave');

Route::get('/painel/{vue?}', function () {
    return view('admin');
})->where('vue', '[\/\w\.-]*')->name('dashboard');