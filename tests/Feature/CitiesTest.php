<?php

test('checking schema cities', function () {
    $this->assertTrue(\Illuminate\Support\Facades\Schema::hasColumns(
        'cities',
        ['id', 'external_id', 'country_id', 'name', 'name_ascii', 'capital', 'population', 'lat', 'lng', 'created_at', 'updated_at']
    ));
});
