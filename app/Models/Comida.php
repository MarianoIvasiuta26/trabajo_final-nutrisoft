<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_comida'
    ];

    public function alimentosRecomendadosPorDietas()
    {
        return $this->hasMany(AlimentosRecomendadosPorDieta::class);
    }
}
