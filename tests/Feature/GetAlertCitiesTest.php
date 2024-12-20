<?php

test('Getting Alert Cities', function () {
    $this->refreshDatabase();

    \Illuminate\Support\Facades\Artisan::call('app:get-countries');

    $this->assertTrue(\App\Models\Country::count() >= 250, 'The countries table must have 250 or more records.');
});
