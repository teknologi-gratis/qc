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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('loginsaksi','API\ControllerLogin@loginsaksi');
Route::post('inputsuara','API\ControllerLogin@InputSuara');
Route::post('tampilcalon','API\ControllerLogin@TampilCalon');
Route::post('updatedatatps', 'API\ControllerLogin@updateDataTpsSuara');
Route::post('updatesuaracalon', 'API\ControllerLogin@updatesuaracalon');
