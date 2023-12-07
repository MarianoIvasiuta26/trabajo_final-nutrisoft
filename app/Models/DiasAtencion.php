<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiasAtencion extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'dia',
        'seleccionado',
    ];

    public function horariosAtencion(){
        return $this->hasMany('App\Models\HorariosAtencion');
    }
}
