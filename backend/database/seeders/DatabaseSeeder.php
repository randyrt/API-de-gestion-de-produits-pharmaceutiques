<?php

namespace Database\Seeders;

// use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory()->count(3)->create();

        $this->call([
            ProductSeeder::class,
        ]);
    }
}
