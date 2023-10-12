<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnosTemporales extends Model
{
    use HasFactory;

    protected $fillable = [
        'turno_id_cancelado',
        'turno_id_adelantado',
        'confirmado'
    ];

    public function turnoCancelado()
    {
        return $this->belongsTo(Turno::class, 'turno_id_cancelado');
    }

    public function turnoAdelantado()
    {
        return $this->belongsTo(Turno::class, 'turno_id_adelantado');
    }
}
