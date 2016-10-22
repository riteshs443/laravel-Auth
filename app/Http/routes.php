<?php

use App\Http\Response;
use App\Http\Requests;
use Illuminate\Http\Request;

Route::post('register', 'APIController@register');

Route::post('registermail', 'eddofamail@register');

Route::post('verifyemail', 'APIController@verifyemail');

Route::post('login', 'APIController@login');

Route::post('getuserdetails', [
	'middleware' => 'jwt-auth',
	'uses' =>'APIController@get_user_details',
]);

Route::post('changepassword', 'APIController@changepwd');

Route::post('forgetpassword', 'APIController@forgetpwd');

Route::post('forgetpasswordupdate', 'APIController@forgetpwdupdate');