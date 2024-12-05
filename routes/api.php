<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReviewProductController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SupplierController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Shipping;
use Database\Seeders\ProductsTableSeeder;
use Hamcrest\Number\OrderingComparison;

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

Route::get('suppliers', [SupplierController::class, 'index']);
Route::post('suppliers', [SupplierController::class, 'store']);
Route::put('suppliers/{supplier}', [SupplierController::class, 'update']);
Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy']);

Route::post('orders', [OrderController::class, 'store']);
Route::get('orders', [OrderController::class, 'index']);
Route::put('orders/{order}', [OrderController::class, 'update']);
Route::delete('orders/{order}', [OrderController::class, 'destroy']);

Route::post('shippings', [ShippingController::class, 'store']);