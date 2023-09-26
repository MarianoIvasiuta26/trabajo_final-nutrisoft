<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutricionista extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function horariosAtencion(){
        return $this->hasMany('App\Models\HorariosAtencion');
    }

    public function consulta(){
        return $this->hasMany('App\Models\Consulta');
    }
}
