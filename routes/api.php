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






Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::get('get/videos/{category}', [App\Http\Controllers\VideoController::class, 'apivideos']);
    Route::get('get/categories', [App\Http\Controllers\CategoriesController::class, 'categories']);

    Route::get('get/categories_with_videos', [App\Http\Controllers\CategoriesController::class, 'categoriesWithVideos']);

});
