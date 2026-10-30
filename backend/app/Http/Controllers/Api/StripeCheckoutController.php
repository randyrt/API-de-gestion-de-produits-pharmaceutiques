<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeCheckoutController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $user = $request->user();

        $secretKey = config('services.stripe.secret');

        if (!$user) {
            return response()->json([
                'message' => 'Utilisateur non authentifié.',
            ], 401);
        }

        if (!is_string($secretKey) || !str_starts_with($secretKey, 'sk_')) {
            return response()->json([
                'message' => 'La configuration Stripe est invalide.',
            ], 500, [], JSON_PRETTY_PRINT);
        }

        $stripe = new StripeClient($secretKey);
        
        $amountInCents = (int) round((float) $product->price * 100);

        if ($amountInCents < 1 || strtolower($product->currency) !== 'eur') {
            return response()->json([
                'message' => 'Prix ou devise du produit invalide.',
            ], 422);
        }

        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => $amountInCents,
            'currency' => 'eur',
            'status' => 'pending',
        ]);

        try {
            $session = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => $product->name,
                            ],
                            'unit_amount' => $amountInCents,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'success_url' => 'http://localhost:8000/payment/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'http://localhost:8000/payment/cancel',
                'metadata' => [
                    'order_id' => (string) $order->id,
                ],
            ]);

            $order->update([
                'stripe_session_id' => $session->id,
            ]);

            return response()->json([
                'order_id' => $order->id,
                'checkout_url' => $session->url,
            ]);
        } catch (\Throwable $e) {
            $order->update(['status' => 'failed']);

            report($e);

            return response()->json([
                'message' => 'Impossible de créer la session de paiement.',
            ], 500);
        }
    }

}
