<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorNutricional extends Model
{
    use HasFactory;

    protected $fillable = [
        'alimento_id',
        'nombre',
        'fuente_alimento_id',
        'unidad',
        'valor',
        'tipo',
    ];

    public function alimento()
    {
        return $this->belongsTo(Alimento::class, 'id_alimento');
    }

    public function fuenteAlimento()
    {
        return $this->belongsTo(FuenteAlimento::class, 'id_fuente_alimento');
    }
}
