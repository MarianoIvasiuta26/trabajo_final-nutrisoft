<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorasAtencion extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'hora_inicio',
        'hora_fin',
        'etiqueta',
    ];

    public function horariosAtencion(){
        return $this->hasMany('App\Models\HorariosAtencion');
    }
}
