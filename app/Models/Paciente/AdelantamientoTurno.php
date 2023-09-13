<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdelantamientoTurno extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'dias_fijos',
        'horas_fijas',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
