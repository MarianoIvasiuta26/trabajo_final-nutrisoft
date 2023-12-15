<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory;
    //use SoftDeletes;

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

    public function planDeSeguimiento()
    {
        return $this->hasMany('App\Models\PlanDeSeguimiento');
    }

    public function registroAlimentosConsumidos(){
        return $this->hasMany('App\Models\RegistroAlimentosConsumidos');
    }

    public function intoleranciasPaciente()
    {
        return $this->hasMany('App\Models\Paciente\IntoleranciasPaciente');
    }

    public function patologiasPaciente()
    {
        return $this->hasMany('App\Models\Paciente\PatologiasPaciente');
    }

    public function alergiasPaciente()
    {
        return $this->hasMany('App\Models\Paciente\AlergiasPaciente');
    }

}
