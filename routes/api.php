<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Product;
use App\Http\Controllers\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('client')->group(function () {
    Route::post('register', Client\CreateController::class);
    Route::get('{id}', [ClientController::class, 'show']);
});

Route::post('/product/create', Product\CreateController::class);
