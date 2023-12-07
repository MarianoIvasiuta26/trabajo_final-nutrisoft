<?php

namespace App\Models;

use App\Models\Paciente\Intolerancia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlimentosProhibidosIntolerancia extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'intolerancia_id',
        'alimento_id',
    ];

    public function intolerancia()
    {
        return $this->belongsTo(Intolerancia::class);
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class);
    }

}
