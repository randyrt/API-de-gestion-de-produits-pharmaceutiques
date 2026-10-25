<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function low(Request $request): JsonResponse
    {
        $threshold = 10;

        $products = Product::query()
            ->where('user_id', $request->user()->id)
            ->where('stock', '<=', $threshold)
            ->orderBy('stock')
            ->get([
                'id',
                'name',
                'price',
                'stock',
                'is_active',
            ]);

        return response()->json([
            'message' => 'Produits en stock faible récupérés avec succès.',
            'threshold' => $threshold,
            'data' => $products,
        ]);
    }
}
