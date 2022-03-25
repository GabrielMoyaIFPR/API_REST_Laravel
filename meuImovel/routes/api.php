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
    Route::prefix('real-states')->group(function () {
        Route::get('/', 'RealStateController@index')->name('index');
        Route::get('/{id}', 'RealStateController@show')->name('show');
        Route::post('/', 'RealStateController@store')->name('store');
        Route::put('/{id}', 'RealStateController@update')->name('update');
        Route::patch('/{id}', 'RealStateController@update')->name('update');
        Route::delete('/{id}', 'RealStateController@destroy')->name('destroy');
    });
});