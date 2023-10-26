<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlimentoPorTipoDeDieta extends Model
{
    use HasFactory;

    protected $fillable = [
        'alimento_id',
        'tipo_de_dieta_id',
    ];

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }

    public function tipoDeDieta()
    {
        return $this->belongsTo(TiposDeDieta::class);
    }

    public function alimentosRecomendadosPorDietas()
    {
        return $this->hasMany(AlimentosRecomendadosPorDieta::class);
    }
}
