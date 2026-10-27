<?php

use App\Http\Controllers\Api\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook', [
    StripeWebhookController::class,
    'handle',
]);