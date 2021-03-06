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

Route::get('/', function () {
    return view('welcome');
});

Route::any('/wechat', 'WechatController@serve');



Route::group(['middleware' => ['web']], function (){

    Route::get('/menu','MenuController@menu');

    Route::get('/users','UsersController@users');
    Route::get('/user/{openId}','UsersController@user');

    Route::get('/image','MaterialController@image');
    Route::get('/video','MaterialController@video');
    Route::get('/news','MaterialController@news');

    Route::get('/person/{openId}','PosterController@person');
    Route::get('/uploadposter/{openId}','PosterController@uploadposter');
    Route::get('/getqrcode/{openId}','PosterController@getqrcode');
    Route::get('/generateqrcode','PosterController@generateqrcode');
});