<?php
namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory()->count(3)->create();

        foreach ($users as $user) {
            Product::factory()
                ->count(5)
                ->for($user)
                ->create();
        }
    }
}
