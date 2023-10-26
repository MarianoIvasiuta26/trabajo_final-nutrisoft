<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesMedidasPorComida extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_unidad_medida',
    ];

    public function alimentosRecomendadosPorDietas(){
        return $this->hasMany(AlimentosRecomendadosPorDieta::class);
    }
}
