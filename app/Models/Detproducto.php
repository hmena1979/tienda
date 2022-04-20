<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detproducto extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detproductos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function producto(){
        return $this->belongsTo('App\Models\Producto');
    }

    public function detingreso(){
        return $this->hasOne('App\Models\Detingreso');
    }

    public function detrventa(){
        return $this->hasOne('App\Models\Detrventa');
    }

    // public function marca()
    // {
    //     return $this->hasOne('App\Models\Catproducto', 'id', 'marca_id')->whereIn('modulo',['0','2']);
    // }

    // public function talla()
    // {
    //     return $this->hasOne('App\Models\Catproducto', 'id', 'talla_id')->whereIn('modulo',['0','3']);
    // }

    // public function color()
    // {
    //     return $this->hasOne('App\Models\Catproducto', 'id', 'color_id')->whereIn('modulo',['0','4']);
    // }
}
