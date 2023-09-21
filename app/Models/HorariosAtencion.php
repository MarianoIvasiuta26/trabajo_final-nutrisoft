<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorariosAtencion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nutricionista_id',
        'dia_atencion_id',
        'hora_atencion_id',
    ];

    public function diasAtencion(){
        return $this->belongsTo('App\Models\DiasAtencion');
    }

    public function nutricionista(){
        return $this->belongsTo('App\Models\Nutricionista');
    }

    public function horasAtencion(){
        return $this->belongsTo('App\Models\HorasAtencion');
    }

    public function turno(){
        return $this->hasMany('App\Models\Turno');
    }
}
