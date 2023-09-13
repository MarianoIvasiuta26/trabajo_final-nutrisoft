<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'alimento',
        'grupo_alimento',
        'fuente',
        'estacional',
        'estacion',
    ];

    public function anamnesisAlimentaria(){
        return $this->hasMany('App\Models\Paciente\AnamnesisAlimentaria');
    }

}
