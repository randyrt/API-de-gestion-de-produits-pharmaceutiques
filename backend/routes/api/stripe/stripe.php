<?php



use App\Http\Controllers\Api\StripeCheckoutController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->post('/products/{product}/checkout',[StripeCheckoutController::class, 'store']);