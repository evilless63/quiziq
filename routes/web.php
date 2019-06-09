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

    Route::post('rankteamupdate', 'RankController@rankteamupdate')->name('rankteamupdate');


    Route::resource('game', 'GameController');

    Route::post('ajaxRequestUpdateGame', 'GameController@ajaxRequestUpdateGame');
    Route::post('ajaxRequestFinalizeGame', 'GameController@ajaxRequestFinalizeGame');

    Route::get('manage_game/{id}', 'GameController@manageGame')->name('manage_game');
    Route::get('start_game/{id}', 'GameController@startGame')->name('start_game');
    Route::post('add_comment_game/{id}', 'GameController@addCommentGame')->name('add_comment_game');
    
    
    Route::get('/', function(){
       return Redirect::to('admin');
    });


});
Route::group(['namespace' => 'admin'], function(){
Route::get('show_game_client/{id}', 'GameController@showClientGame')->name('show_game_client');
});