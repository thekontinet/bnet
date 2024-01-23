<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('package:upload');
        Plan::factory()->create([
            'title' => 'Monthly Plan',
            'price' => 200000,
            'duration' => 1,
            'interval' => 'month'
        ]);

        Plan::factory()->create([
            'title' => 'Bi Monthly Plan',
            'price' => 550000,
            'duration' => 3,
            'interval' => 'month'
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
