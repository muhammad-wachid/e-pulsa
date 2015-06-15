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

Route::get('/', 'PulsaController@index');
Route::post('/topup', ['as' => 'topup', 'uses' => 'PulsaController@topup']);
Route::post('/inquiry', ['as' => 'inquiry', 'uses' => 'PulsaController@inquiry']);
