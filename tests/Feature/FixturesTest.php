<?php

use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Team;

it('can view a fixtures page', function () {
    $previousGameweek = Gameweek::factory()->previous()->create();
    $currentGameweek = Gameweek::getCurrent();
    $nextGameweek = Gameweek::factory()->next()->create();

    $currentFixtures = Fixture::factory()->times(2)->for($currentGameweek)->withTeams()->create();
    Fixture::factory()->times(2)->for($previousGameweek)->withTeams()->create();
    Fixture::factory()->times(2)->for($nextGameweek)->withTeams()->create();

    $response = $this->get('/fixtures');

    $response->assertOk()
        ->assertSeeText($currentGameweek->name)
        ->assertViewHas('fixtures', $currentFixtures);
});

it('can view a fixtures page for previous gameweek', function () {
    $previousGameweek = Gameweek::factory()->previous()->create();
    $currentGameweek = Gameweek::getCurrent();
    $nextGameweek = Gameweek::factory()->next()->create();

    $previousFixtures = Fixture::factory()->times(2)->for($previousGameweek)->withTeams()->create();
    Fixture::factory()->times(2)->for($currentGameweek)->withTeams()->create();
    Fixture::factory()->times(2)->for($nextGameweek)->withTeams()->create();

    $response = $this->get("/fixtures?gameweek={$previousGameweek->id}");

    $response->assertOk()
        ->assertSeeText($previousGameweek->name)
        ->assertViewHas('fixtures', $previousFixtures);
});

it('cannot view a fixture show page', function () {
    $homeTeam = Team::factory()->create();
    $awayTeam = Team::factory()->create();

    $fixture = Fixture::factory()
        ->for(Gameweek::getCurrent())
        ->withTeams($homeTeam, $awayTeam)
        ->create();

    $response = $this->get("/fixtures/{$fixture->id}/show");

    $response->assertOk()
        ->assertViewHas('fixture', $fixture)
        ->assertSeeText($homeTeam->name)
        ->assertSeeText($awayTeam->name);
});
