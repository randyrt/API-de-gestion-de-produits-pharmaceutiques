<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        if (!$signature || !$webhookSecret) {
            return response()->json([
                'message' => 'Signature ou configuration webhook manquante.',
            ], 400, [], JSON_PRETTY_PRINT);
        }

        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $webhookSecret
            );
        } catch (UnexpectedValueException $e) {
            return response()->json([
                'message' => 'Payload invalide.',
            ], 400, [], JSON_PRETTY_PRINT);
        } catch (SignatureVerificationException $e) {
            return response()->json([
                'message' => 'Signature Stripe invalide.',
            ], 400, [], JSON_PRETTY_PRINT);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // Vérifier que le paiement est réellement réussi.
            if ($session->payment_status !== 'paid') {
                return response()->json([
                    'message' => 'Paiement pas encore confirmé.',
                ]);
            }

            $orderId = $session->metadata->order_id ?? null;

            if (!$orderId) {
                Log::warning('Webhook Stripe : order_id manquant.', [
                    'session_id' => $session->id,
                ]);

                return response()->json([
                    'message' => 'Commande introuvable dans les métadonnées.',
                ], 400, [], JSON_PRETTY_PRINT);
            }

            $order = Order::where('id', $orderId)
                ->where('stripe_session_id', $session->id)
                ->first();

            if (!$order) {
                Log::warning('Webhook Stripe : commande introuvable.', [
                    'order_id' => $orderId,
                    'session_id' => $session->id,
                ]);

                return response()->json([
                    'message' => 'Commande introuvable.',
                ], 404, [], JSON_PRETTY_PRINT);
            }

            // Mise à jour idempotente : un webhook répété
            // ne doit pas provoquer d'effet supplémentaire.
            if ($order->status !== 'paid') {
                $order->update([
                    'status' => 'paid',
                ]);
            }
        }

        return response()->json([
            'received' => true,
        ]);
    }
}