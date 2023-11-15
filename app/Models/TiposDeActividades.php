<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposDeActividades extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_actividad'
    ];

    public function actividadesPorTiposDeActividades(){
        return $this->hasMany(ActividadesPorTiposDeActividades::class);
    }

    public function tiposActividadesPorTratamientos(){
        return $this->hasMany(TiposActividadesPorTratamientos::class);
    }

}
