<?php

namespace App\Models;

use App\Models\Paciente\Cirugia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActividadesProhibidasCirugia extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'cirugia_id',
        'actividad_id'
    ];

    public function cirugia(){
        return $this->belongsTo(Cirugia::class);
    }

    public function actividad(){
        return $this->belongsTo(Actividades::class);
    }
}
