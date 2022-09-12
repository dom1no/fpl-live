<?php

namespace Database\Factories;

use App\Models\Manager;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ManagerFactory extends Factory
{
    protected $model = Manager::class;

    public function definition(): array
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
