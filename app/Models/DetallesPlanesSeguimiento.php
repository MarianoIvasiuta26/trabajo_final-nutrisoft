<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallesPlanesSeguimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_de_seguimiento_id',
        'act_rec_id',
        'actividad_id',
        'completada',
        'tiempo_realizacion',
        'unidad_tiempo_realizacion',
        'recursos_externos',
        'estado_imc',
        'peso_ideal',
    ];

    public function planDeSeguimiento()
    {
        return $this->belongsTo(PlanesDeSeguimiento::class);
    }

    public function actividad()
    {
        return $this->belongsTo(Actividades::class);
    }

    public function ActividadRecPorTipoActividades(){
        return $this->belongsTo(ActividadRecPorTipoActividades::class);
    }
}
