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

Route::get('/categories/main/{appliedModel}', 'api\CategoriesController@main');
Route::get('/categories/all/{appliedModel}', 'api\CategoriesController@index');
Route::get('/categories/{id}', 'api\CategoriesController@get');
Route::get('/categories/{id}/children', 'api\CategoriesController@child');
Route::get('/categories/{id}/parent', 'api\CategoriesController@parent');

// 公司清單
Route::get('/sites/list', 'api\SitesController@index');
Route::get('/sites/list/published', 'api\SitesController@publishedIndex');

// 最新消息清單
Route::get('/news/list', 'api\NewsController@index');

// 相關連結清單
Route::get('/links/list', 'api\LinksController@index');

// 產品清單 
Route::get('/products/list', 'api\ProductsController@index');

// Banner清單
Route::get('/banners/list', 'api\BannersController@index');
Route::get('/banners/list/published', 'api\BannersController@publishedIndex');
