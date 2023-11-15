<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadRecPorTipoActividades extends Model
{
    use HasFactory;

    protected $fillable = [
        'act_tipoAct_id',
        'duracion_actividad',
        'unidad_tiempo_id',
    ];

    public function actividadPorTipoActividad()
    {
        return $this->belongsTo(ActividadesPorTiposDeActividades::class);
    }

}
