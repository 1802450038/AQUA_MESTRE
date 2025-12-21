<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $guarded = ['id'];

    // O timestamp 'updated_at' não é necessário para logs imutáveis, economiza espaço
    public $timestamps = true; 
    
    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
