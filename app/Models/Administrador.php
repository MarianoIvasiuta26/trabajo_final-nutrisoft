<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Administrador extends Model
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
}
