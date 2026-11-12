<?php

use App\Models\Idea;
use App\Models\User;

it('updates an idea via feature test', function () {
    $user = User::factory()->create();

    $idea = Idea::factory()->create([
        'user_id' => $user->id,
    ]);
    $idea->steps()->create(['description' => 'Keep this step']);

    $response = $this->actingAs($user)->from(route('idea.show', $idea))->patch(route('idea.update', $idea), [
        'title' => 'My Updated Idea',
        'status' => 'pending',
    ]);

    $response->assertRedirect(route('idea.show', $idea));

    expect($idea->refresh())->title->toBe('My Updated Idea');
    expect($idea->steps()->pluck('description')->all())->toBe(['Keep this step']);
});

it('updates, removes, and adds steps without duplicating', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for($user)->create();
    $keep = $idea->steps()->create(['description' => 'keep']);
    $idea->steps()->create(['description' => 'remove']);

    $this->actingAs($user)->patch(route('idea.update', $idea), [
        'title' => $idea->title,
        'status' => 'pending',
        'steps' => [
            ['id' => $keep->id, 'description' => 'kept and edited', 'completed' => true],
            ['id' => null, 'description' => 'brand new', 'completed' => false],
        ],
    ]);

    expect($idea->steps()->orderBy('id')->pluck('description')->all())->toBe(['kept and edited', 'brand new']);
    expect($keep->refresh()->completed)->toBeTruthy();
});

it('removes every step when the update sends an empty step list', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for($user)->create();
    $idea->steps()->create(['description' => 'remove me']);

    $this->actingAs($user)->patch(route('idea.update', $idea), [
        'title' => $idea->title,
        'status' => 'pending',
        'steps' => [],
    ]);

    expect($idea->steps()->count())->toBe(0);
});
