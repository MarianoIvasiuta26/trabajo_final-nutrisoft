<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuenteAlimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'fuente',
    ];

    public function valorNutricional(){
        return $this->hasMany('App\Models\ValorNutricional');
    }
}
