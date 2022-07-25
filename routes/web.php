<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Models\Item;
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
    $categories = Category::root()->get();
    // return $categories;
      return view('welcome',[
        'categories'=> $categories
      ]);
  });

// Route::get('/categories/{category:id}/products', [ProductController::class, 'categories'])->name('categories');