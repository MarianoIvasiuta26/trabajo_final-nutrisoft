<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActividadesPorTiposDeActividades extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'actividad_id',
        'tipo_actividad_id',
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividades::class);
    }

    public function tipoDeActividad()
    {
        return $this->belongsTo(TiposDeActividades::class);
    }

    public function actividadRecPorTipoActividades()
    {
        return $this->hasMany(ActividadRecPorTipoActividades::class);
    }
}
