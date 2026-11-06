<?php

use App\Models\Idea;
use App\Models\User;

test('must be logged in to view idea', function () {
    $idea = Idea::factory()->create();
    $this->get(route('idea.show', $idea))->assertRedirectToRoute('login');
});

it('requires authorization to view idea', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $idea = Idea::factory()->create();
    $this->get(route('idea.show', $idea))->assertForbidden();
});

it('can view idea it created', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $idea = $user->ideas()->create([
        'title' => 'My First Idea',
        'description' => 'This is my first idea description.',
        'status' => 'pending',
    ]);
    $this->get(route('idea.show', $idea))->assertSee('My First Idea');
});
