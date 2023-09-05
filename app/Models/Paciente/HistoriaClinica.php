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
        'objetivo_Salud',
    ];
    public function paciente(){
        return $this->belongsTo('App/Models/Paciente');
    }
}
