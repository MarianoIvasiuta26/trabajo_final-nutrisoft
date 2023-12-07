<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuenteAlimento extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'fuente',
    ];

    public function valorNutricional(){
        return $this->hasMany('App\Models\ValorNutricional');
    }
}
