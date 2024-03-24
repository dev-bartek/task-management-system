<?php

use App\Models\User;

it('will show admin link in the navigation to admin user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/tasks');

    $response
        ->assertOk()
        ->assertDontSee('Admin');

    $admin = User::factory()->admin()->create();

    $this->actingAs($admin);

    $response = $this->get('/tasks');

    $response
        ->assertOk()
        ->assertSee('Admin');
});
