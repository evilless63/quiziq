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


Auth::routes(['register' => false, 'reset'=>false]);

Route::group(['namespace' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('admin', 'AdminController@index');
    Route::resource('team', 'TeamController');
    Route::resource('rank', 'RankController');
    Route::resource('game', 'RankController');
    Route::get('/', function(){
       return Redirect::to('admin');
    });


});