<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TratamientoPorPaciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'tratamiento_id',
        'fecha_alta',
        'fecha_baja',
        'observaciones',
        'estado'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }

}
