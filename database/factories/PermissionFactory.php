<?php

namespace Database\Factories;

use App\Models\MenuResource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'menu_resource_id' => MenuResource::factory(),
            'name' => fake()->unique()->name(),
        ];
    }
}
