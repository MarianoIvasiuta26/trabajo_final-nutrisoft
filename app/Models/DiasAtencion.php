<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasAtencion extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia',
        'seleccionado',
    ];

    public function horariosAtencion(){
        return $this->hasMany('App\Models\HorariosAtencion');
    }
}
