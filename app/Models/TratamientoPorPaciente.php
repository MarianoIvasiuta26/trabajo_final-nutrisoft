<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TratamientoPorPaciente extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
