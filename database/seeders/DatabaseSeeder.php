<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Plans;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Plans::create([
            'name' => 'Basic',
            'credits' => 100,
            'price' => 9.99,
            'description' => 'Starter credits',
        ]);
        
        Plans::create([
            'name' => 'Standard',
            'credits' => 250,
            'price' => 19.99,
            'description' => 'More value for your money',
        ]);
        
        Plans::create([
            'name' => 'Premium',
            'credits' => 500,
            'price' => 34.99,
            'description' => 'Best for power users',
        ]);
        
    }
}
