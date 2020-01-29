<?php
Route::post('/ckeditor/upload', 'admin\PhotosController@ckeditorUpload');
Route::post('summernoteUpload', 'admin\PhotosController@summerNoteUpload');

/** 首頁*/
Route::get('/', 'app\HomeController@index');

/** 公司簡介*/
Route::get('/abouts', 'app\AboutsController@index');

/** 最新消息*/
Route::get('/news', 'app\NewsController@index');
Route::get('/news/{id}', 'app\NewsController@show');

/** 聯絡我們**/
Route::get('/contact', 'app\ContactController@create');
Route::post('/contact', 'app\ContactController@store');
Route::get('/contact-ok', 'app\ContactController@contactOk');

/** 產品與類別**/
Route::get('/products/category/{catId}', 'app\ProductsController@index');
Route::get('/products', 'app\ProductsController@index');

/** 相關連結 **/
Route::get('/links', 'app\LinksController@index');

/** 系統後台*/
Route::group(["prefix" => "admin", 'middleware' => ['web', 'auth'], 'namespace' => 'admin'], function () {

    Route::get('/', function () {
        return view('system.home');
    });

    /** 公司簡介-多項清單*/
    Route::patch('abouts/ranking', 'AboutsController@ranking');
    Route::patch('abouts/action', 'AboutsController@action');
    Route::get('abouts/{about}/copy', 'AboutsController@copy');
    Route::resource('abouts', 'AboutsController');

    /** 公司簡介-靜態畫面*/
    Route::get('/intro', 'IntroController@edit');
    Route::patch('/intro', 'IntroController@update');

    /** 廣告管理*/
    Route::patch('ads/ranking', 'AdsController@ranking');
    Route::resource('ads', 'AdsController');
    
    /***** 產品類別管理 ******/
    Route::patch('product/categories/ranking', 'ProductCategoriesController@ranking');
    Route::resource('product/categories', 'ProductCategoriesController');

    /***** 產品管理 ******/
    Route::get('product/publishedInHome', 'ProductsController@getPublishedInHome');
    Route::any('products/list', 'ProductsController@getList');
    Route::patch('products/ranking', 'ProductsController@ranking');
    Route::patch('products/action', 'ProductsController@action');
    Route::get('products/config', 'ProductsController@config');
    Route::get('products/{product}/copy', 'ProductsController@copy');
    Route::resource('products', 'ProductsController');

    /***** 消息類別 ******/
    Route::patch('news/categories/ranking', 'NewsCategoriesController@ranking');
    Route::resource('news/categories', 'NewsCategoriesController');
    
    /** 最新消息管理*/
    Route::patch('news/ranking', 'NewsController@ranking');
    Route::patch('news/action', 'NewsController@action');
    Route::get('news/{news}/copy', 'NewsController@copy');
    Route::resource('news', 'NewsController');

    /***** 相關連結類別 ******/
    Route::patch('links/categories/ranking', 'LinksCategoriesController@ranking');
    Route::resource('links/categories', 'LinksCategoriesController');

    /** 相關連結管理*/
    Route::patch('links/ranking', 'LinksController@ranking');
    Route::patch('links/action', 'LinksController@action');
    Route::resource('links', 'LinksController');
    
    /** 據點管理*/
    Route::patch('sites/ranking', 'SitesController@ranking');
    Route::resource('sites', 'SitesController');

    /** 圖檔管理*/
    Route::delete('photos/{filename}', 'PhotosController@destroy');
    Route::patch('photos/{filename}', 'PhotosController@update');

    /** 聯絡我們管理*/
    Route::get('contacts/template', 'ContactsController@template');
    Route::patch('contacts/template', 'ContactsController@updateTemplate');
    Route::post('contacts/{id}/processed', 'ContactsController@processed');
    Route::resource('contacts', 'ContactsController');

    /**設定管理*/
    Route::group(['prefix' => 'settings'], function () {
        Route::get('companyInfo', 'SettingsController@companyInfo');
        Route::patch('companyInfo', 'SettingsController@updateCompanyInfo');

        Route::get('marketingInfo', 'SettingsController@marketingInfo');
        Route::patch('marketingInfo', 'SettingsController@updateMarketingInfo');

        Route::get('pageInfo', 'SettingsController@pageInfo');
        Route::patch('pageInfo', 'SettingsController@updatePageInfo');
        
        Route::patch('mailService', 'SettingsController@updateMailService');
        Route::get('mailService', 'SettingsController@mailService');
        
        Route::get('password', 'SettingsController@password');
    });

    /** 使用說明*/
    Route::get('readme', 'ReadmeController@index');
});

/** 登入登出*/
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

/** 變更密碼*/
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
