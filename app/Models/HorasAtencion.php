<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorasAtencion extends Model
{
    use HasFactory;

    protected $fillable = [
        'hora_inicio',
        'hora_fin',
        'etiqueta',
    ];

    public function horariosAtencion(){
        return $this->hasMany('App\Models\HorariosAtencion');
    }
}
