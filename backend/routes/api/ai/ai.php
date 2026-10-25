<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AIController;

Route::middleware('auth:sanctum')->post('/chat', [AIController::class,'chat',]);