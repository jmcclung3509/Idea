<?php

use App\Models\Idea;
use App\Models\User;

test('it belongs to user', function () {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);

});

test('it can have steps', function () {
    $idea = Idea::factory()->create();

    expect($idea->steps)->toBeEmpty(); // toBeInstanceOf(Collection::class);

    $idea->steps()->create([
        'description' => 'Do the thing',
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);
});

test('a step belongs to its idea', function () {
    $idea = Idea::factory()->create();
    $step = $idea->steps()->create(['description' => 'Do the thing']);

    expect($step->idea)->toBeInstanceOf(Idea::class);
    expect($step->idea->is($idea))->toBeTrue();
});
