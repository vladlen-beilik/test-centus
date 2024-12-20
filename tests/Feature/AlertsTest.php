<?php

test('checking schema alerts', function () {
    $this->assertTrue(\Illuminate\Support\Facades\Schema::hasColumns(
        'alerts',
        ['id', 'user_id', 'country_id', 'city_id', 'uvi', 'precipitation', 'created_at', 'updated_at']
    ));
});

test('creating alert', function () {
    $user = \App\Models\User::factory()->create(['email' => 'test@gmail.com']);
    $country = \App\Models\Country::factory()->create(['name' => 'Test Country']);
    $city = \App\Models\City::factory()->create(['name' => 'Test City', 'name_ascii' => 'Test City', 'country_id' => $country->id]);

    $this->assertDatabaseHas('users', ['email' => 'test@gmail.com']);
    $this->assertDatabaseHas('countries', ['name' => 'Test Country']);
    $this->assertDatabaseHas('cities', ['name' => 'Test City', 'name_ascii' => 'Test City', 'country_id' => $country->id]);

    $data = [
        'user_id' => $user->id,
        'country_id' => $country->id,
        'city_id' => $city->id,
        'uvi' => 'low',
        'precipitation' => 'low'
    ];

    \App\Models\Alert::create($data);
    $this->assertDatabaseHas('alerts', $data);
});
