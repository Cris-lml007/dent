<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ci' => fake()->unique()->randomNumber(7,true),
            'name' => fake()->name(),
            'birthdate' => fake()->date(),
            'gender' => fake()->numberBetween(0,1),
            'phone' => fake()->randomNumber(7,true),
            'ref_phone' => fake()->randomNumber(7,true)
        ];
    }
}
