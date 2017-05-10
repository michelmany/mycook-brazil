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

Route::get('/painel/{vue?}', function () {
    return view('admin');
})->where('vue', '[\/\w\.-]*')->name('dashboard');