<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Diagnostico extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    //use SoftDeletes;

    protected $fillable = [
        'consulta_id',
        'descripcion_diagnostico',
    ];

    public function consulta(){
        return $this->belongsTo(Consulta::class);
    }

    public function tagsDiagnostico(){
        return $this->hasMany(TagsDiagnostico::class);
    }

}
