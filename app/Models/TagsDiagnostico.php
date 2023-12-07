<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TagsDiagnostico extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    //use SoftDeletes;

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
