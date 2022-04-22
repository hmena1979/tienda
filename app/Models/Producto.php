<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'productos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    // public function detproductos()
    // {
    //     return $this->hasMany('App\Models\Detproducto');
    // }

    public function detingreso(){
        return $this->hasOne('App\Models\Detingreso');
    }

    public function detrventa(){
        return $this->hasOne('App\Models\Detrventa');
    }
    
    public function tmpdetsalida(){
        return $this->hasOne('App\Models\Tmpdetsalida');
    }

    public function umedida(){
        return $this->belongsTo('App\Models\Umedida', 'umedida_id', 'codigo');
    }

    public function materiaprima()
    {
        return $this->hasOne('App\Models\Materiaprima');
    }
}
