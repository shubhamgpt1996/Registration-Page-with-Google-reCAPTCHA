<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/register');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/registerUser', 'UserController@registerUser');
Route::post('/captcha-verification', 'UserController@captchaVerification');
Route::post('/validate-user', 'UserController@validateUser');
