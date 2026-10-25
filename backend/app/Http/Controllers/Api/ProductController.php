<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = $request->user()
            ->products()
            ->latest()
            ->paginate(10);

        return response()->json($products);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $product = $request->user()
            ->products()
            ->create($validated);

        return response()->json([
            'message' => 'Produit créé avec succès.',
            'data' => $product,
        ], 201);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $product = $request->user()
            ->products()
            ->findOrFail($id);

        return response()->json(['data' => $product]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $product = $request->user()
            ->products()
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'description' => ['sometimes', 'nullable', 'string'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Produit modifié avec succès.',
            'data' => $product->refresh(),
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $product = $request->user()
            ->products()
            ->findOrFail($id);

        $product->delete();

        return response()->json([
            'message' => 'Produit supprimé avec succès.',
        ]);
    }
}
