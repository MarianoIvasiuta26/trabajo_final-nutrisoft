<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdelantamientoTurno extends Model
{
    use HasFactory;
    //use SoftDeletes;

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
