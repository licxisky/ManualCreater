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

Route::get('/', 'ManualController@index');
Route::get('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');
Route::get('/{manual}/{secret}', 'ManualController@manual');

Route::post('/add', 'ManualController@add');
Route::get('/up/{manual}', 'ManualController@up');
Route::get('/down/{manual}', 'ManualController@down');
Route::post('/edit/{manual}', 'ManualController@edit');
Route::get('/delete/{manual}', 'ManualController@delete');
Route::get('/str/{str}', 'ManualController@str');

Route::post('/imageupload', 'ManualController@imageUpload');

