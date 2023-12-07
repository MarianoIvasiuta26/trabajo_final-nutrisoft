<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActividadRecPorTipoActividades extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'act_tipoAct_id',
        'duracion_actividad',
        'unidad_tiempo_id',
    ];

    public function actividadPorTipoActividad()
    {
        return $this->belongsTo(ActividadesPorTiposDeActividades::class);
    }

    public function unidadTiempo()
    {
        return $this->belongsTo(UnidadesDeTiempo::class);
    }

    public function detallesPlanesSeguimiento()
    {
        return $this->hasMany(DetallesPlanesSeguimiento::class);
    }

}
