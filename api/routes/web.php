<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/mailable', function (){
	return new App\Mail\UserStocksDaily(App\User::first());
});
