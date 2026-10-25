<?php

use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    require __DIR__.'/api/user/user.php';
});

Route::prefix('products')->group(function () {
    require __DIR__.'/api/product/product.php';
});

Route::prefix('ai')->group(function () {
    require __DIR__.'/api/ai/ai.php';
});


Route::prefix('stocks')->group(function () {
    require __DIR__.'/api/stock/stock.php';
});