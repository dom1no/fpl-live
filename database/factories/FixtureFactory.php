<?php

namespace Database\Factories;

use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FixtureFactory extends Factory
{
    protected $model = Fixture::class;

    public function definition(): array
    {
        return [
            'kickoff_time' => Carbon::now(),
            'is_started' => fake()->boolean(),
            'is_finished' => fake()->boolean(),
            'is_finished_provisional' => fake()->boolean(),
            'is_bonuses_added' => fake()->boolean(),
            'minutes' => fake()->randomNumber(),
            'fpl_id' => fake()->unique()->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'gameweek_id' => fn () => Gameweek::factory(),
        ];
    }

    public function withTeams(?Team $homeTeam = null, ?Team $awayTeam = null): static
    {
        $homeTeam ??= Team::factory()->create();
        $awayTeam ??= Team::factory()->create();

        return $this->hasAttached($homeTeam, ['is_home' => true], 'teams')
            ->hasAttached($awayTeam, ['is_home' => false], 'teams');
    }
}
