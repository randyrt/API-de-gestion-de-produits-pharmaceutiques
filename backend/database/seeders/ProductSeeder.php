<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'mark.metz@example.net')->first();

        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Pharmacie Centrale',
                'email' => 'pharmacie@example.net',
            ]);
        }

        $products = [
            [
                'name' => 'Paracétamol 500 mg',
                'description' => 'Comprimés de paracétamol dosés à 500 mg.',
                'price' => 2500,
                'stock' => 120,
                'is_active' => true,
            ],
            [
                'name' => 'Amoxicilline 500 mg',
                'description' => 'Antibiotique à base d’amoxicilline. Délivrance selon prescription médicale.',
                'price' => 8500,
                'stock' => 45,
                'is_active' => true,
            ],
            [
                'name' => 'Vitamine C 1000 mg',
                'description' => 'Comprimés effervescents de vitamine C.',
                'price' => 6000,
                'stock' => 80,
                'is_active' => true,
            ],
            [
                'name' => 'Ibuprofène 200 mg',
                'description' => 'Comprimés à base d’ibuprofène.',
                'price' => 3500,
                'stock' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Solution antiseptique',
                'description' => 'Solution antiseptique pour usage externe.',
                'price' => 7500,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Sérum physiologique',
                'description' => 'Solution saline stérile en unidoses.',
                'price' => 4000,
                'stock' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Thermomètre numérique',
                'description' => 'Thermomètre électronique pour mesurer la température corporelle.',
                'price' => 18000,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Masques chirurgicaux',
                'description' => 'Boîte de masques chirurgicaux à usage unique.',
                'price' => 12000,
                'stock' => 0,
                'is_active' => false,
            ],
        ];

        foreach ($products as $product) {
            $slug = Str::slug($product['name']);

            Product::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'slug' => $slug,
                ],
                [
                    ...$product,
                    'slug' => $slug,
                ]
            );
        }
    }
}