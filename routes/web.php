<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/test', function () {
    return view('home');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/Category', [App\Http\Controllers\CategoriesController::class, 'index'])->name('categories');
    Route::post('/Category/Store', [App\Http\Controllers\CategoriesController::class, 'store'])->name('category.store');
    Route::post('/Category/Delete', [App\Http\Controllers\CategoriesController::class, 'delete'])->name('category.delete');

    // Route::get('/Category/{id}/edit', [App\Http\Controllers\CategoriesController::class, 'edit'])->name('category.edit');

    Route::post('/Category/update', [App\Http\Controllers\CategoriesController::class, 'update'])->name('category.update');

    Route::get('/Profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('/Profile/Update', [App\Http\Controllers\UserController::class, 'update'])->name('profile.update');

    Route::get('Videos', [App\Http\Controllers\VideoController::class, 'index'])->name('videos.index');

    Route::get('Videos/Create', [App\Http\Controllers\VideoController::class, 'create'])->name('videos.create');
    Route::get('Videos/edit/{id}', [App\Http\Controllers\VideoController::class, 'edit'])->name('videos.edit');
    Route::post('Videos/Save', [App\Http\Controllers\VideoController::class, 'save'])->name('videos.save');
    Route::post('/Videos/Delete', [App\Http\Controllers\VideoController::class, 'delete'])->name('video.delete');
    Route::post('Videos/Update', [App\Http\Controllers\VideoController::class, 'update'])->name('videos.update');


});




