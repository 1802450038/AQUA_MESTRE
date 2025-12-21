<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Board extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'settings' => 'array', // Converte JSON para Array automaticamente
        'last_seen_at' => 'datetime',
        'ota_enabled' => 'boolean',
        'battery_level' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        // Antes de criar, gera a API KEY se não existir
        static::creating(function ($board) {
            if (empty($board->api_key)) {
                $board->api_key = Str::random(64);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }

    // Helper para saber se está online (considerando 3x o intervalo de envio como margem)
    public function isOnline()
    {
        if (!$this->last_seen_at) return false;
        
        // Exemplo: Se o intervalo é 1 min, consideramos offline após 3 min sem sinal
        $threshold = $this->data_interval * 3; 
        return $this->last_seen_at->diffInMinutes(now()) < $threshold;
    }
}
