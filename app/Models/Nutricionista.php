<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nutricionista extends Model
{
    use HasFactory;
    //use SoftDeletes;

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
