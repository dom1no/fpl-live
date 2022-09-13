<?php

use App\Models\Manager;

it('can view a login form', function () {
    $response = $this->get('/login');

    $response->assertOk()
        ->assertSeeText('Логин');
});

it('cannot view a login form when authenticated', function () {
    $manager = Manager::factory()->create();

    $response = $this->actingAs($manager)
        ->get('/login');

    $response->assertRedirect('/');
});

it('can login with correct name', function () {
    $manager = Manager::factory()->create();

    $response = $this->post('/login', [
        'name' => $manager->name,
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/');
});

it('cannot login with a non-existent name', function () {
    $manager = Manager::factory()->create();

    $response = $this->post('/login', [
        'name' => $manager->name . '-non-existent',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['name']);
});

it('can logout, when already authenticated', function () {
    $manager = Manager::factory()->create();

    $response = $this->actingAs($manager)
        ->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
