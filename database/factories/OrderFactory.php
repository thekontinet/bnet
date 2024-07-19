<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate random values for the fields
        $owner = $this->faker->randomElement([Customer::class, Organization::class]);
        $total = $this->faker->numberBetween(10, 1000);
        $status = 'pending';
        $reference = Str::random(10);
        $data = ['extra_field' => $this->faker->sentence()]; // Example of additional data


        // Define the model's attributes
        return [
            'tenant_id' => null, // Example of nullable field
            'owner_type' => $owner, // Example of polymorphic association
            'owner_id' => $owner::factory(),
            'item_type' => $this->faker->randomElement([Package::class]), // Example of polymorphic association
            'item_id' => Package::factory(),
            'purchase_price' => rand(100, 1000),
            'sale_price' => rand(100, 1000),
            'purchase_discount' => 0,
            'sale_discount' => 0,
            'total' => $total,
            'reference' => $reference,
            'status' => $status,
            'data' => $data,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
