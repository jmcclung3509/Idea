<?php

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

it('registers a user', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'john@example.com')
        ->fill('password', 'password123!!!!')
        ->click('Create Account')
        ->assertPathIs('/ideas')
        ->assertSee('Ideas');

    /** @var TestCase $this */
    $this->assertAuthenticated();
    expect(Auth::user())->toMatchArray([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

it('requires a email to register', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('password', 'password123!!!!')
        ->fill('email', '')
        ->click('Create Account')
        ->assertSee('The email field is required.');
});
