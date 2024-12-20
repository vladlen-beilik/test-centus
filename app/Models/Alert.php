<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'country_id',
        'city_id',
        'uvi',
        'precipitation'
    ];

    protected $with = ['country', 'city'];

    public static array $uviLevelMessages = [
        'low' => 'Low risk of skin damage. It is safe to be outside without protection.',
        'moderate' => 'Moderate risk. Protection is recommended (sunglasses, hat).',
        'high' => 'High risk of damage. Protective measures are needed.',
        'very_high' => 'Very high risk of damage. Maximum protection is mandatory.',
        'extreme' => 'Extremely dangerous. Protective measures are essential; avoiding the sun is better.',
    ];

    public static array $precipitationLevelMessages = [
        'dry' => 'No precipitation. The weather is dry.',
        'low' => 'Light precipitation. Almost negligible, but might feel damp.',
        'moderate' => 'Moderate precipitation. Noticeable but not heavy.',
        'high' => 'Significant precipitation. Could include steady rain or showers.',
        'very_high' => 'Very high precipitation. Heavy rainfall, likely leading to water pooling.',
        'extreme' => 'Extreme precipitation. Intense rainfall, risk of flooding or severe weather.',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public static function getUviLevel(int $level): string
    {
        return match (true) {
            $level >= 3 && $level <= 5 => 'moderate',
            $level >= 6 && $level <= 7 => 'high',
            $level >= 8 && $level <= 10 => 'very_high',
            $level >= 11 => 'extreme',
            default => 'low'
        };
    }

    public static function getPrecipitationLevel(float $level): string
    {
        return match (true) {
            $level >= 0.1 && $level <= 2.5 => 'low',
            $level >= 2.6 && $level <= 7.6 => 'moderate',
            $level >= 7.7 && $level <= 50.0 => 'high',
            $level >= 50.1 && $level <= 99.9 => 'very_high',
            $level >= 100.0 => 'extreme',
            default => 'dry'
        };
    }
}
