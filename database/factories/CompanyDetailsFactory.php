<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'MyCompany',
            'phone' => '9933220011',
            'email' => 'email@company.com',
            'address' => 'address',
            'pin_code' => '22334455',
            'city_id' => City::inRandomOrder()->value('id'), // fetches a real city ID
        ];
    }
}
