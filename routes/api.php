<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
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
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show']);
    Route::put('/user/{id}/update', [App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/user/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
});
Route::get('/sendfeedback', [FeedbackController::class,'create']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/feedback', [App\Http\Controllers\FeedbackController::class, 'index']);
    Route::put('/feedback/{id}', [App\Http\Controllers\FeedbackController::class, 'update']);
    Route::delete('/feedback/{id}/delete', [App\Http\Controllers\FeedbackController::class, 'destroy']);
});