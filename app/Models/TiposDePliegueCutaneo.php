<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposDePliegueCutaneo extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'nombre_pliegue',
        'unidad_de_medida',
        'descripcion',
    ];

    public function medicionesDePlieguesCutaneos(){
        return $this->hasMany(MedicionesDePlieguesCutaneos::class);
    }

}
