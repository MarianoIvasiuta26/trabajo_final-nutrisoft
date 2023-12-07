<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Ingrediente extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    //use SoftDeletes;

    protected $fillable = [
        'alimento_id',
        'receta_id',
        'cantidad',
        'unidad_medida_por_comida_id'
    ];

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function unidad_medida_por_comida()
    {
        return $this->belongsTo(UnidadesMedidasPorComida::class);
    }
}
