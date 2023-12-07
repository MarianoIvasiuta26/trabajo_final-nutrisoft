<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposDeActividades extends Model
{
    use HasFactory;
    //use SoftDeletes;

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
