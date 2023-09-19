<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoNutriente extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_nutriente',
    ];

    public function nutrientes()
    {
        return $this->hasMany(Nutriente::class);
    }

}
