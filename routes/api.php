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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1")->group(function (){
//    Route::get("products/{page?}", "ProductController@getProducts");
//    Route::get("product/{id}", "ProductController@getProduct");
//    Route::apiResource("prodcuts", "ProductController");
    Route::get("products/{page?}", "ProductController@getProducts");
    Route::prefix("product")->group(function (){
        Route::get("{id}", "ProductController@getProduct");
        Route::post("/", "ProductController@register");
        Route::put("{id}", "ProductController@update");
        Route::delete("{id}", "ProductController@delete");
    });
    Route::get("categories/{page?}", "CategoryController@getCategories");
    Route::prefix("category")->group(function (){
        Route::get("{id}", "CategoryController@getCategory");
        Route::post("/", "CategoryController@register");
        Route::put("{id}", "CategoryController@update");
        Route::delete("{id}", "CategoryController@delete");
    });
});
