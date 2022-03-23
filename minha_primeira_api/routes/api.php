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

Route::get('/test', function(){
    $response = new \Illuminate\Http\Response(json_encode(['msg' => 'Primeira resposta']));
    $response->header('Content-Type', 'application/json');
});

Route::namespace('App\Http\Controllers\Api')->prefix('products')->group(function(){

    Route::get('/', 'ProductController@index');
    Route::get('/{id}', 'ProductController@show');
    Route::post('/', 'ProductController@save');
    Route::put('/', 'ProductController@update');
    Route::patch('/', 'ProductController@update');
    Route::delete('/{id}', 'ProductController@delete');
});