<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlimentosRecomendadosPorDieta extends Model
{
    use HasFactory;

    protected $fillable = [
        'alimento_por_dieta_id',
        'comida_id',
        'cantidad',
        'unidad_medida_id',
    ];

    public function alimentoPorTipoDieta()
    {
        return $this->belongsTo(AlimentoPorTipoDeDieta::class);
    }

    public function comida()
    {
        return $this->belongsTo(Comida::class);
    }

    public function unidadesMedidasPorComida()
    {
        return $this->belongsTo(UnidadesMedidasPorComida::class);
    }
}
