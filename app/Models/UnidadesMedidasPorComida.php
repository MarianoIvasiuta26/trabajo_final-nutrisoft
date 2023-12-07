<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadesMedidasPorComida extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'nombre_unidad_medida',
    ];

    public function alimentosRecomendadosPorDietas(){
        return $this->hasMany(AlimentosRecomendadosPorDieta::class);
    }

    public function ingredientes()
    {
        return $this->hasMany(Ingrediente::class);
    }
}
