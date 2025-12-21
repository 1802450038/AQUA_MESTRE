<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $guarded = ['id'];


    protected $casts = [
        'calibration_data' => 'array',
        'is_analog' => 'boolean',
        'is_active' => 'boolean',
        'last_calibrated_at' => 'datetime',
        'last_read_at' => 'datetime',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }
    
    // Pega a última medição rápida
    public function lastMeasurement()
    {
        return $this->hasOne(Measurement::class)->latestOfMany();
    }
}
