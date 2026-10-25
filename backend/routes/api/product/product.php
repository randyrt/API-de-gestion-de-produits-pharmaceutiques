<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{id}', [ProductController::class, 'show'])
        ->whereNumber('id');
    Route::put('/{id}', [ProductController::class, 'update'])
        ->whereNumber('id');
    Route::patch('/{id}', [ProductController::class, 'update'])
        ->whereNumber('id');
    Route::delete('/{id}', [ProductController::class, 'destroy'])
        ->whereNumber('id');
});
