<?php

test('checking schema countries', function () {
    $this->assertTrue(\Illuminate\Support\Facades\Schema::hasColumns(
        'countries',
        ['id', 'name', 'cca2', 'icon', 'lat', 'lng', 'created_at', 'updated_at']
    ));
});

test('filling the database with countries', function () {
    $this->refreshDatabase();

    \Illuminate\Support\Facades\Artisan::call('app:get-countries');

    $this->assertTrue(\App\Models\Country::count() >= 250, 'The countries table must have 250 or more records.');
});
