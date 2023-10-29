<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

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
