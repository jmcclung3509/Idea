<?php

use App\Models\User;
use Tests\TestCase;

it('logs in a user', function () {
    $user = User::factory()->create(['password' => 'password123!!!!']);
    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password123!!!!')
        ->click('@login-button')
        ->assertPathIs('/ideas')
        ->assertSee('Ideas');
});

it('logs out a user', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();
    $this->actingAs($user);
    visit('/')
        ->click('@logout-button');

    $this->assertGuest();
});
