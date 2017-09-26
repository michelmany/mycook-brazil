<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth'], function () {
    Route::post('login','Api\Auth\AuthController@authenticate');
    Route::get('logout','Api\Auth\AuthController@logout');
    Route::get('check','Api\Auth\AuthController@check');
    /**
    | Moip Services
     */
    Route::prefix('services/moip')->group(function() {
        Route::get('check', 'Api\Auth\MoipController@checkSellerAuthorization');
    });
});


Route::group(['prefix' => 'admin/v1', 'namespace'=>'Api\Admin\V1'], function () {
    Route::resource('users','UsersController');
    Route::post('users/avatar/{id}','UsersController@avatar');
    Route::resource('address','AddressesController');
    
    Route::resource('products', 'ProductsController');
    Route::post('products/photo/{id}','ProductsController@photo');
    Route::resource('extras', 'ProductExtrasController');

    Route::group(['prefix' => 'orders'], function() {
        Route::get('/', 'Moip\OrderController@index');
        Route::get('{order}', 'Moip\OrderController@show');
    });
});

Route::post('/quero-vender', 'UserController@sellerRegisterPost')->name('queroVenderPost');
Route::post('/quero-vender-fotos', 'UserController@photoSellerUpload')->name('queroVenderPost');
Route::post('/fotos-register', 'UserController@fotosRegisterPost')->name('fotosRegisterPost');

