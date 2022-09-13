<?php

use App\Models\Gameweek;
use App\Models\Manager;

beforeEach(fn () => Manager::factory()->times(3)->create());

it('can view a managers page', function () {
    $response = $this
        ->actingAs(Manager::first())
        ->get('/managers');

    $response->assertOk()
        ->assertSeeText(Gameweek::getCurrent()->name)
        ->assertViewHas('managers', Manager::all()->keyBy('id'));
});

it('can view a managers page for previous gameweek', function () {
    $previousGameweek = Gameweek::factory()->previous()->create();

    $response = $this
        ->actingAs(Manager::first())
        ->get("/managers?gameweek={$previousGameweek->id}");

    $response->assertOk()
        ->assertSeeText($previousGameweek->name)
        ->assertViewHas('managers', Manager::all()->keyBy('id'));
});

it('cannot view a managers page when not authenticated', function () {
    $response = $this->get('/managers');

    $response->assertRedirect('/login');
});

it('can view a manager show page', function () {
    $authManager = Manager::first();
    $manager = Manager::offset(1)->first();

    $response = $this
        ->actingAs($authManager)
        ->get("/managers/{$manager->id}/show");

    $response->assertOk()
        ->assertSeeText(Gameweek::getCurrent()->name)
        ->assertSeeText($manager->name)
        ->assertViewHas('manager', $manager);
});

it('can view a manager show page for previous gameweek', function () {
    $previousGameweek = Gameweek::factory()->previous()->create();

    $authManager = Manager::first();
    $manager = Manager::offset(1)->first();

    $response = $this
        ->actingAs($authManager)
        ->get("/managers/{$manager->id}/show?gameweek={$previousGameweek->id}");

    $response->assertOk()
        ->assertSeeText($previousGameweek->name)
        ->assertSeeText($manager->name)
        ->assertViewHas('manager', $manager);
});
