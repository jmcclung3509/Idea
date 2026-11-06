<?php

use App\Models\Idea;
use App\Models\User;
use Tests\TestCase;

it('creates a new idea', function () {
    /** @var TestCase $this */
    $this->actingAs($user = User::factory()->create());
    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('@title-input', 'Test Idea')
        ->fill('@description-input', 'Test Description')
        ->click('@button-status-completed')
        ->fill('@new-link-input', 'https://example.com')
        ->fill('@new-step-input', 'Step 1')
        ->click('@add-step-button')
        ->fill('@new-step-input', 'Step 2')
        ->click('@add-step-button')
        ->click('@add-link-button')
        ->assertValue('input[x-model="link"]', 'https://example.com')
        ->click('@submit-button')
        ->assertPathIs('/ideas');

    expect(Idea::count())->toBe(1);
    expect($user->ideas()->first())->toMatchArray([
        'title' => 'Test Idea',
        'description' => 'Test Description',
        'status' => 'completed',
        'links' => ['https://example.com'],
        'steps' => [
            ['description' => 'Step 1'],
            ['description' => 'Step 2'],
        ],
    ]);
});
