<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosMedicos extends Model
{
    use HasFactory;

    protected $fillable = [
        'historia_clinica_id',
        'alergia_id',
        'patologia_id',
        'cirugia_id',
        'intolerancia_id',
        'valor_analisis_clinico_id',
    ];

    public function historiaClinica(){
        return $this->belongsTo('App/Models/Paciente/HistoriaClinica');
    }

    public function alergia(){
        return $this->belongsTo('App/Models/Paciente/Alergia');
    }

    public function patologia(){
        return $this->belongsTo('App/Models/Paciente/Patologia');
    }

    public function cirugia(){
        return $this->belongsTo('App/Models/Paciente/Cirugia');
    }

    public function intolerancia(){
        return $this->belongsTo('App/Models/Paciente/Intolerancia');
    }

    public function valorAnalisisClinico(){
        return $this->belongsTo('App/Models/Paciente/ValorAnalisisClinico');
    }

}
