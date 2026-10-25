<?php


use App\Http\Controllers\Api\StockController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get(
    '/low',
    [StockController::class, 'low']
);