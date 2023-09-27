<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'turno_id',
        'nutricionista_id',
        'peso_actual',
        'altura_actual',
        'circunferencia_munieca_actual',
        'circunferencia_cintura_actual',
        'circunferencia_cadera_actual',
        'circunferencia_pecho_actual',
        'diagnostico',
    ];

    public function turno(){
        return $this->belongsTo('App\Models\Turno');
    }

    public function nutricionista(){
        return $this->belongsTo('App\Models\Nutricionista');
    }
}