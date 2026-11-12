<?php

use App\Models\User;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\Notification;

it('emails the original address when the email changes', function () {
    Notification::fake();

    $user = User::factory()->create([
        'name' => 'Ada Lovelace',
        'email' => 'ada@example.net',
    ]);

    $this->actingAs($user)->patch(route('profile.update'), [
        'name' => 'Ada Lovelace',
        'email' => 'ada@example.com',
    ])->assertRedirect(route('profile.edit'));

    expect($user->refresh()->email)->toBe('ada@example.com');

    Notification::assertSentOnDemand(
        EmailChanged::class,
        function (EmailChanged $notification, array $channels, object $notifiable): bool {
            $mail = $notification->toMail($notifiable);

            return $notifiable->routes['mail'] === 'ada@example.net'
                && $mail->subject === 'Your email address was changed'
                && $mail->actionText === 'Review your profile'
                && collect($mail->introLines)->contains(
                    fn (string $line) => str_contains($line, 'ada@example.net') && str_contains($line, 'ada@example.com')
                );
        }
    );
});

it('does not email when the address stays the same', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->actingAs($user)->patch(route('profile.update'), [
        'name' => 'Updated Name',
        'email' => $user->email,
    ])->assertRedirect(route('profile.edit'));

    Notification::assertNothingSent();
});
