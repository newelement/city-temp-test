<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $casts = [
        'temperature_date' => 'date',
    ];

    protected $appends = [
        'temperature_cel',
        'temperature_far'
    ];

    // Could also make a blade directive to convert the scales. -- Don
    public function getTemperatureCelAttribute()
    {
        // Could also make a matrix to convert K and R scales ... -- Don
        $temp = $this->temperature_scale === 'F' ? ($this->temperature - 32) / 1.8 : $this->temperature;
        return round($temp);
    }

    public function getTemperatureFarAttribute()
    {
        $temp = $this->temperature_scale === 'C' ? ($this->temperature * 9/5) + 32 : $this->temperature;
        return round($temp);
    }
}
