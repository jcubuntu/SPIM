<?php

Route::group(['as' => 'auth.'], function() {
	Route::get('login', ['as' => 'login', 'uses' => 'AuthController@showLogin']);
	Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);
	Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
});

