<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

it('creates a new idea via feature test', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('idea.store'), [
        'title' => 'My First Idea',
        'status' => 'completed',
        'description' => 'This is my first idea description.',
        'steps' => [
            ['description' => 'Do a thing', 'completed' => false],
            ['description' => 'Do another thing', 'completed' => false],
        ],
        'image' => UploadedFile::fake()->image('thumbnail.jpg'),
        'links' => ['https://linear-code-mastery.com/', 'https://laravel.com/'],
    ]);

    $response->assertRedirect('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'My First Idea',
        'status' => 'completed',
        'description' => 'This is my first idea description.',
    ]);

    expect($idea->steps)->toHaveCount(2);
});
