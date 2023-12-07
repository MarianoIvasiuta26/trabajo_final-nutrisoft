<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Receta extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'nombre_receta',
        'tiempo_preparacion',
        'porciones',
        'unidad_de_tiempo_id',
        'recursos_externos',
        'preparacion'
    ];

    public function unidad_de_tiempo()
    {
        return $this->belongsTo(UnidadesDeTiempo::class);
    }


    public function ingredientes()
    {
        return $this->hasMany(Ingrediente::class);
    }

}
