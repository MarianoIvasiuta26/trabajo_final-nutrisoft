<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoNutriente extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'tipo_nutriente',
    ];

    public function nutrientes()
    {
        return $this->hasMany(Nutriente::class);
    }

}
