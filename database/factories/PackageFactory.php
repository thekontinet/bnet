<?php

namespace Database\Factories;

use App\Enums\ServiceEnum;
use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'service' => fake()->randomElement(ServiceEnum::cases()),
            'provider' => fake()->randomElement(['MTN', 'GLO', '9MOBILE', 'AIRTEL']),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'price_type' => fake()->randomElement([Package::PRICE_TYPE_FIXED, Package::PRICE_TYPE_DISCOUNT]), // Assuming 3 price types
            'price' => fake()->numberBetween(100, 1000),
            'discount' => fake()->numberBetween(0, 50),
            'active' => true,
        ];
    }
}
