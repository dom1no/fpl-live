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
            'name' => $this->faker->name(),
            'deadline_at' => Carbon::now()->addDay(),
            'is_finished' => $this->faker->boolean(),
            'is_previous' => $this->faker->boolean(),
            'is_current' => $this->faker->boolean(),
            'is_next' => $this->faker->boolean(),
            'fpl_id' => $this->faker->randomNumber(),
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
