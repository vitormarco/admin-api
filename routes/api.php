<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::post('logout', 'Auth\AuthController@logout')->name('logout');
    Route::post('refresh', 'Auth\AuthController@refresh')->name('refresh');
    Route::post('me', 'Auth\AuthController@me')->name('me');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'User\UserController@all')->name('all');
        Route::post('/create', 'User\UserController@create')->name('create');
        Route::post('/update/{id}', 'User\UserController@update')->name('update');
        Route::get('/edit/{id}', 'User\UserController@edit')->name('edit');
        Route::delete('/delete/{id}', 'User\UserController@delete')->name('delete');
    });
});
