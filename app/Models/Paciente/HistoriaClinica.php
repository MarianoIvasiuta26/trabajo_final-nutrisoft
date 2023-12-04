<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'peso',
        'altura',
        'circunferencia_munieca',
        'circunferencia_cintura',
        'circunferencia_cadera',
        'circunferencia_pecho',
        'estilo_vida',
        'objetivo_salud',
    ];
    public function paciente(){
        return $this->belongsTo('App\Models\Paciente');
    }

    public function datosMedicos(){
        return $this->hasMany('App\Models\Paciente\DatosMedicos');
    }

    public function anamnesisAlimentaria(){
        return $this->hasMany('App\Models\Paciente\AnamnesisAlimentaria');
    }

    public function cirugiasPaciente(){
        return $this->hasMany('App\Models\Paciente\CirugiasPaciente');
    }

    public function medicionesDePlieguesCutaneos(){
        return $this->hasMany('App\Models\Paciente\MedicionesDePlieguesCutaneos');
    }

}
