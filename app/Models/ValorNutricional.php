<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorNutricional extends Model
{
    use HasFactory;

    protected $fillable = [
        'alimento_id',
        'fuente_alimento_id',
        'nutriente_id',
        'unidad',
        'valor',
    ];

    public function alimento()
    {
        return $this->belongsTo(Alimento::class, 'alimento_id');
    }

    public function fuenteAlimento()
    {
        return $this->belongsTo(FuenteAlimento::class, 'fuente_alimento_id');
    }

    public function nutriente()
    {
        return $this->belongsTo(Nutriente::class, 'nutriente_id');
    }
}
