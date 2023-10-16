<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposDePliegueCutaneo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_pliegue',
        'unidad_de_medida',
        'descripcion',
    ];

    public function medicionesDePlieguesCutaneos(){
        return $this->hasMany(MedicionesDePlieguesCutaneos::class);
    }

}
