<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['middleware'=>'auth', function () {
    return view('welcome');
}]);

Route::get('/home', function(){
	return redirect('/');
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['middleware'=>'auth', 'prefix' => 'api', 'namespace'=> 'API'], function(){
	Route::controller('articles', 'ArticleCtrl');
	Route::controller('weixins', 'WeixinCtrl');
	Route::controller('tags', 'Tags');

	Route::controller('dash', 'Data');
});
