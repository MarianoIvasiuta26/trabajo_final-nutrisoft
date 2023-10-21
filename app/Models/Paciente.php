<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dni',
        'sexo',
        'fecha_nacimiento',
        'edad',
        'telefono',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function historiaClinica()
    {
        return $this->hasOne('App\Models\Paciente\HistoriaClinica');
    }

    public function adelantamientoTurno()
    {
        return $this->hasMany('App\Models\Paciente\AdelantamientoTurno');
    }

    public function turno()
    {
        return $this->hasMany('App\Models\Turno');
    }

    public function tratamientoPorPaciente()
    {
        return $this->hasMany('App\Models\Paciente\TratamientoPorPaciente');
    }

    public function planAlimentaciones()
    {
        return $this->hasMany('App\Models\PlanAlimentaciones');
    }

}
