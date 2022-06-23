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

    public function mpobtenidas()
    {
        return $this->hasMany('App\Models\Mpobtenida');
    }

    public function detingreso(){
        return $this->hasOne('App\Models\Detingreso');
    }

    public function detrventa(){
        return $this->hasOne('App\Models\Detrventa');
    }

    public function detguia(){
        return $this->hasOne('App\Models\Detguia');
    }
    
    public function tmpdetsalida(){
        return $this->hasOne('App\Models\Tmpdetsalida');
    }
    
    public function tmpdetguia(){
        return $this->hasOne('App\Models\Tmpdetguia');
    }

    public function umedida(){
        return $this->belongsTo('App\Models\Umedida', 'umedida_id', 'codigo');
    }

    public function tipoproducto(){
        // return $this->belongsTo('App\Models\Umedida', 'umedida_id', 'codigo');
        return $this->hasOne('App\Models\Catproducto', 'id', 'tipoproducto_id')->where('modulo',1);
    }

    // public function catproducto(){
    //     // return $this->belongsTo('App\Models\Umedida', 'umedida_id', 'codigo');
    //     return $this->hasOne('App\Models\Catproducto', 'id', 'tipoproducto_id')->where('modulo',1);
    // }

    public function materiaprima()
    {
        return $this->hasOne('App\Models\Materiaprima');
    }

    public function detcotizacion()
    {
        return $this->hasOne('App\Models\Detcotizacion');
    }

    public function detordcompra()
    {
        return $this->hasOne('App\Models\Detordcompra');
    }

    public function detpedido()
    {
        return $this->hasOne('App\Models\Detpedido');
    }

    public function saldo(){
        return $this->hasOne('App\Models\Saldo');
    }

    public function detparteproducto(){
        return $this->hasOne('App\Models\Detparteproducto');
    }
}
