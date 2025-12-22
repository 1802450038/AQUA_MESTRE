<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apikey extends Model
{
    protected $guarded = ['id'];


    protected static function boot()
    {
        parent::boot();

        // Antes de criar, gera a API KEY se não existir
        static::creating(function ($apikey) {
            if (empty($apikey->key)) {
                $apikey->key = bin2hex(random_bytes(32)); // Gera uma chave de 64 caracteres
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

}
