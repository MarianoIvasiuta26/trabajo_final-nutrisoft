<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutricionista extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dias_atencion',
        'hora_inicio_maniana',
        'hora_fin_maniana',
        'hora_inicio_tarde',
        'hora_fin_tarde',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
