<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->namespace('App\Http\Controllers\Api')->group(function () {

    Route::post('/login', 'Auth\LoginJwtController@login')->name('login');
    Route::get('/logout', 'Auth\LoginJwtController@logout')->name('logout');
    Route::get('/refresh', 'Auth\LoginJwtController@refresh')->name('refresh');

    Route::get('/search', 'RealStateSearchController@index')->name('search');
    Route::get('/search/{real_state_id}', 'RealStateSearchController@show')->name('search_single');


    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::prefix('real-states')->group(function () {
            Route::get('/', 'RealStateController@index')->name('index');
            Route::get('/{id}', 'RealStateController@show')->name('show');
            Route::post('/', 'RealStateController@store')->name('store');
            Route::put('/{id}', 'RealStateController@update')->name('update');
            Route::patch('/{id}', 'RealStateController@update')->name('update');
            Route::delete('/{id}', 'RealStateController@destroy')->name('destroy');
        });

        Route::prefix('users')->group(function () {
            Route::get('/', 'UserController@index')->name('index');
            Route::get('/{id}', 'UserController@show')->name('show');
            Route::post('/', 'UserController@store')->name('store');
            Route::put('/{id}', 'UserController@update')->name('update');
            Route::patch('/{id}', 'UserController@update')->name('update');
            Route::delete('/{id}', 'UserController@destroy')->name('destroy');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', 'CategoryController@index')->name('index');
            Route::get('/{id}', 'CategoryController@show')->name('show');
            Route::post('/', 'CategoryController@store')->name('store');
            Route::put('/{id}', 'CategoryController@update')->name('update');
            Route::patch('/{id}', 'CategoryController@update')->name('update');
            Route::delete('/{id}', 'CategoryController@destroy')->name('destroy');

            Route::get('/{id}/real-states', 'CategoryController@realStates')->name('real-states');
        });

        Route::name('photos.')->prefix('photos')->group(function () {
            Route::delete('/{id}', 'RealStatePhotoController@remove')->name('delete');
            Route::put('/set-thumb/{photoId}/{realStateId}', 'RealStatePhotoController@setThumb')->name('update');
        });
    });
});

