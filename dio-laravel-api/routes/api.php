<?php

use Illuminate\Http\Request;


Route::get('bands', 'BandController@getAll');
Route::post('bands/store', 'BandController@store');
Route::get('bands/gender/{gender}', 'BandController@getBandsByGender');
Route::get('bands/{id}', 'BandController@getById');



Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();

});
