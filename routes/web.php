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

Route::get('/painel/{vue?}', function () {
    return view('admin');
})->where('vue', '[\/\w\.-]*')->name('dashboard');