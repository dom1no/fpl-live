<?php

namespace Database\Factories;

use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manager>
 */
class ManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'command_name' => fake()->word(),
            'total_points' => fake()->randomNumber(),
            'fpl_id' => fake()->randomNumber(),
            'password' => Hash::make('qwerty'),
            'remember_token' => Str::random(10),
        ];
    }
}
