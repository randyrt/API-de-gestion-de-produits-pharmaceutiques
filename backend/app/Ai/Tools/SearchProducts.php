<?php

namespace App\Ai\Tools;

use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class SearchProducts implements Tool
{
    public function __construct(
        private User $user
    ) {}

    public function description(): Stringable|string
    {
        return 'Recherche les produits de l’utilisateur authentifié par nom ou description et retourne leurs prix, stocks et statuts.';
    }

    public function handle(Request $request): Stringable|string
    {
        $term = trim((string) $request['query']);

        if ($term === '') {
            return 'Veuillez préciser le nom ou la description du produit recherché.';
        }

        $products = $this->user->products()
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            })
            ->select([
                'id',
                'name',
                'description',
                'price',
                'stock',
                'is_active',
            ])
            ->limit(10)
            ->get();

        // $products = $this->user->products()
        //     ->where(function ($query) use ($term) {
        //         $query->where('name', 'like', "%{$term}%")
        //             ->orWhere('description', 'like', "%{$term}%")
        //             ->orWhere('stock', '<=', 10);
        //     })
        //     ->select([
        //         'id',
        //         'name',
        //         'description',
        //         'price',
        //         'stock',
        //         'is_active',
        //     ])
        //     ->limit(10)
        //     ->get();

        return json_encode(
            $products,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        ) ?: '[]';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema
                ->string()
                ->description(
                    'Nom ou terme à rechercher dans le nom ou la description du produit.'
                )
                ->required(),
        ];
    }
}
