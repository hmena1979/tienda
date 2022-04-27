<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detmasivo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detmasivos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function masivo(){
        return $this->belongsTo('App\Models\Masivo');
    }

    public function rcompra(){
        return $this->belongsTo('App\Models\Rcompra');
    }
}
