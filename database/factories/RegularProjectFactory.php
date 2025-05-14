<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegularProject>
 */
class RegularProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'branch_id' => 2,
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(),
            'cost' => $this->faker->randomFloat(2, 100, 1000)
        ];
    }
}
