<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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
Route::get('/signup', [UserController::class,'create']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    // User Section
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show']);
    Route::put('/user/{id}/update', [App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/user/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

    // Feedback Section
    Route::get('/sendfeedback', [FeedbackController::class,'create']);
    Route::get('/feedback', [App\Http\Controllers\FeedbackController::class, 'index']);
    Route::put('/feedback/{id}', [App\Http\Controllers\FeedbackController::class, 'update']);
    Route::delete('/feedback/{id}/delete', [App\Http\Controllers\FeedbackController::class, 'destroy']);;


    Route::controller(CategoryController::class)->group( function(){

        Route::get('/category/add','create')->name('category.create');
        Route::get('/category/list','index');
        Route::get('/subCategory/list','subcategory');
        Route::delete('/cat/delete/{id}','destroy');
        Route::put('/category/{id}/update', 'editCategory');
        Route::put('/subCategory/{id}/update', 'editSubCategory');
    
    
        // Route::get('/cat/show','show')->name('category.store');
        Route::group(['middleware' => 'auth:sanctum'], function () {
        });
    });
});
    Route::controller(ProductController::class)->group(function () {
        Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/categories/{category:id}', 'categories')->name('categories');
        Route::get('/createProduct', 'create');
        Route::get('/product/{id}', 'show');
        Route::put('/product/{id}/update', 'update');
        Route::delete('/product/{id}/delete', 'destroy');
        });
    });
    Route::get('/categories/{category:id}', [ProductController::class, 'categories'])->name('categories');
    