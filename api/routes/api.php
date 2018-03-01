<?php

use Illuminate\Http\Request;

// Routes for /auth/...  that are located in .../Auth/ folder
Route::middleware('api')->prefix('v1/auth')->namespace('Auth')->group(function() {
	Route::post('register', 'RegisterController@register');
	Route::post('login', 'LoginController@login');
	Route::post('forgot-password', 'ForgotPasswordController@sendResetLinkEmail');
	Route::post('reset-password', 'ResetPasswordController@reset');

	Route::post('refreshToken', 'LoginController@refreshToken');
});


Route::middleware('auth:api')->prefix('v1/user')->group(function() {

	Route::get('stocks', 'UserStocksController@index');
	Route::post('stocks', 'UserStocksController@store');
	Route::put('stocks/{uuid}', 'UserStocksController@update');
	Route::delete('stocks/all/{symbol}', 'UserStocksController@removeAllStocksFromSymbol');
	Route::delete('stocks/{uuid}', 'UserStocksController@destroy');

	Route::get('user', function (Request $request) {
		return $request->user();
	});
});

Route::middleware('auth:api')->prefix('v1/stocks')->group(function() {
	Route::get('search/{term}', 'StockController@search');
});
