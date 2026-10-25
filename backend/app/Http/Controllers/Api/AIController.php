<?php

namespace App\Http\Controllers\Api;

use App\Ai\Agents\PharmaAssistant;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Enums\Lab;
use Throwable;

class AIController extends Controller
{
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:4000'],
        ]);

        try {
            $response = (new PharmaAssistant)->prompt(
                $validated['message'],
                provider: Lab::Gemini,
            );

            return response()->json([
                'reply' => (string) $response,
            ]);
        } catch (Throwable $e) {
            Log::error('Erreur PharmaAssistant', [
                'exception' => $e::class,
            ]);

            return response()->json([
                'message' => 'Impossible de contacter l’assistant IA.',
            ], 502);
        }
    }
}
