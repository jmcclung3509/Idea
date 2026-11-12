<?php

use App\Models\Idea;
use App\Models\User;

it('requires authentication to toggle a step', function () {
    $idea = Idea::factory()->create();
    $step = $idea->steps()->create(['description' => 'Ship it']);

    $this->patch(route('step.update', [$idea, $step]))
        ->assertRedirectToRoute('login');

    expect($step->refresh()->completed)->toBeFalsy();
});

it('forbids toggling a step on someone else\'s idea', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();
    $idea = Idea::factory()->for($owner)->create();
    $step = $idea->steps()->create(['description' => 'Ship it']);

    $this->actingAs($intruder)
        ->patch(route('step.update', [$idea, $step]))
        ->assertForbidden();

    expect($step->refresh()->completed)->toBeFalsy();
});

it('rejects a step that belongs to a different idea', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for($user)->create();
    $otherIdea = Idea::factory()->for($user)->create();
    $step = $otherIdea->steps()->create(['description' => 'Elsewhere']);

    $this->actingAs($user)
        ->patch(route('step.update', [$idea, $step]))
        ->assertNotFound();

    expect($step->refresh()->completed)->toBeFalsy();
});

it('toggles a step the user owns', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for($user)->create();
    $step = $idea->steps()->create(['description' => 'Ship it']);

    $this->actingAs($user)
        ->from(route('idea.show', $idea))
        ->patch(route('step.update', [$idea, $step]))
        ->assertRedirect(route('idea.show', $idea));

    expect($step->refresh()->completed)->toBeTruthy();
});
