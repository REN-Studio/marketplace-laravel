<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReviewProductController;
use App\Models\Brand;
use App\Models\Category;
use Database\Seeders\ProductsTableSeeder;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'register']);

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function (){
    Route::get('products', [ProductController::class, 'index']);

    Route::post('products', [ProductController::class, 'store']);

    Route::get('products/{id}', [ProductController::class, 'show']);

    Route::put('products/{id}', [ProductController::class, 'update']);

    Route::delete('products/{id}', [ProductController::class, 'destroy']);

    Route::delete('logout', [LogoutController::class, 'logout']);
});

Route::post('products/{product}/reviews', [ReviewProductController::class, 'store']);
Route::get('products/{product}/reviews', [ReviewProductController::class, 'index']);
Route::put('products/{product}/reviews/{review}', [ReviewProductController::class, 'update']);
Route::delete('products/{product}/reviews/{review}', [ReviewProductController::class, 'destroy']);

Route::get('brands', [BrandController::class, 'index']);
Route::post('brands', [BrandController::class, 'store']);
Route::put('brands/{brand}', [BrandController::class, 'update']);
Route::delete('brands/{brand}', [BrandController::class, 'destroy']);

Route::post('categories', [CategoryController::class, 'store']);
Route::get('categories', [CategoryController::class, 'index']);
Route::put('categories/{category}', [CategoryController::class, 'update']);
Route::delete('categories/{category}', [CategoryController::class, 'destroy']);