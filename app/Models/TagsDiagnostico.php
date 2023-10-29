<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsDiagnostico extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnostico_id',
        'tag_id',
    ];

    public function diagnostico(){
        return $this->belongsTo(Diagnostico::class);
    }

    public function tag(){
        return $this->belongsTo(Tag::class);
    }
}
