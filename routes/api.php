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


Route::group(['prefix' => 'visitors'], function() {
    Route::get('/', 'App\Http\Controllers\Api\VisitorLogController@index');
    Route::post('', 'App\Http\Controllers\Api\VisitorLogController@store');  
    Route::patch('/{id}', 'App\Http\Controllers\Api\VisitorLogController@update');
    Route::delete('/{id}', 'App\Http\Controllers\Api\VisitorLogController@destroy');

    Route::patch('/exit-visitor/{exit_visitor_id}', 'App\Http\Controllers\Api\VisitorLogController@exit');
    Route::post('/search', 'App\Http\Controllers\Api\VisitorLogController@search');
});