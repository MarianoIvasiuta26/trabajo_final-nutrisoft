<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    use HasFactory;

    protected $fillable = [
        'actividad',
    ];

    public function detallesPlanesSeguimiento()
    {
        return $this->hasMany(DetallesPlanesSeguimiento::class);
    }

    public function actividadesPorTiposDeActividades()
    {
        return $this->hasMany(ActividadesPorTiposDeActividades::class);
    }

    public function actividadesProhibidasCirugias()
    {
        return $this->hasMany(ActividadesProhibidasCirugia::class);
    }

    public function actividadesProhibidasPatologias()
    {
        return $this->hasMany(ActividadesProhibidasPatologia::class);
    }

}
