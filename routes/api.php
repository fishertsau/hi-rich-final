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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('/categories/main', 'api\CategoriesController@main');
Route::get('/categories/{id}', 'api\CategoriesController@category');
Route::get('/categories/child/{id}', 'api\CategoriesController@child');
Route::get('/categories/parent/{id}', 'api\CategoriesController@parent');

