<?php

use App\Http\Controllers\Product;
use App\Http\Controllers\Client;
use App\Http\Controllers\Auth;
use App\Http\Controllers\User;
use App\Http\Controllers\Cart;
use App\Http\Controllers\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|-------------------------------------------------------------------------- | API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
});

Route::prefix('client')->group(function () {
    Route::post('register', Client\CreateController::class);
    Route::get('{id}', Client\ShowController::class)->middleware('auth:sanctum');
});

Route::prefix('user')->group(function () {
    Route::post('', User\CreateController::class);
    Route::get('/{id}', User\ShowController::class)->middleware('auth:sanctum');
    Route::get('', User\UserByTokenController::class)->middleware('auth:sanctum');
});

Route::prefix('product')->group(function () {
    Route::post('create', Product\CreateController::class);
    Route::get('', Product\IndexController::class);
    Route::get('/{id}', Product\ShowController::class);
    Route::put('update/{id}', Product\UpdateController::class);
    Route::delete('delete/{id}', Product\DeleteController::class);
});

Route::post('/login', Auth\LoginController::class);
Route::delete('/logout', Auth\LogoutController::class)->middleware('auth:sanctum');

Route::prefix('/cart')->group(function () {
    Route::post('/product', Cart\AddProductToCart::class)->middleware('auth:sanctum');
    Route::get('/{id}', Cart\ShowController::class);
});

Route::prefix('/category')->group(function () {
    Route::get('', Category\IndexController::class);
    Route::get('/{id}', Category\ShowController::class);
});
