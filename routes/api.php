<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\CartController;
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
Route::post('/createProduct', [App\Http\Controllers\ProductController::class, 'create']);
Route::post('/sendfeedback', [App\Http\Controllers\FeedbackController::class, 'create']);
Route::group(['middleware' => 'auth:sanctum'], function () {

    // User Section
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show']);
    Route::put('/user/{id}/update', [App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/user/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

    // Feedback Section
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
        Route::get('/product/{id}', 'show');
        Route::put('/product/{id}/update', 'update');
        Route::delete('/product/{id}/delete', 'destroy');
        });
    });
    Route::controller(CartController::class)->group(function () {
        Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/addCart','addToCart');
        Route::get('/cart','index');
        Route::put('/cart/{id}', 'update');
        Route::delete('/cart/{id}/delete', 'destroy');
        });
    });
    Route::Resource('/shipping',DeliveryController::class);

    Route::get('/categories/{category:id}', [ProductController::class, 'categories'])->name('categories');
    