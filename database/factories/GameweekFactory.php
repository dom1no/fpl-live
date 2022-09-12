<?php

namespace Database\Factories;

use App\Models\Gameweek;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GameweekFactory extends Factory
{
    protected $model = Gameweek::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'deadline_at' => Carbon::now()->addDay(),
            'is_finished' => fake()->boolean(),
            'is_previous' => fake()->boolean(),
            'is_current' => fake()->boolean(),
            'is_next' => fake()->boolean(),
            'fpl_id' => fake()->unique()->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function current(): static
    {
        return $this->state([
            'is_finished' => false,
            'is_previous' => false,
            'is_current' => true,
            'is_next' => false,
        ]);
    }

    public function previous(): static
    {
        return $this->state([
            'is_finished' => true,
            'is_previous' => true,
            'is_current' => false,
            'is_next' => false,
        ]);
    }

    public function next(): static
    {
        return $this->state([
            'is_finished' => false,
            'is_previous' => false,
            'is_current' => false,
            'is_next' => true,
        ]);
    }

    public function finished(): static
    {
        return $this->state([
            'is_finished' => true,
        ]);
    }
}
