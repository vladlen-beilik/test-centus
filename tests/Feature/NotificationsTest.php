<?php

use App\Notifications\WeatherNotification;
use Illuminate\Support\Facades\Notification;

test('sending', function () {
    Notification::fake();

    $user = \App\Models\User::factory()->create(['email' => env('MAIL_FAKE')]);

    $user->notify(new WeatherNotification(
        'Test Country',
        'Test City',
        'low',
        'low'
    ));

    Notification::assertSentTo(
        $user,
        WeatherNotification::class
    );
});
