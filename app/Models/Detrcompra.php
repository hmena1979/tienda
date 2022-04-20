<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detrcompra extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detrcompras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function rcompra(){
        return $this->belongsTo('App\Models\Rcompra');
    }

    public function detdestino(){
        return $this->belongsTo('App\Models\Detdestino');
    }

    public function ccosto(){
        return $this->belongsTo('App\Models\Ccosto');
    }


}
