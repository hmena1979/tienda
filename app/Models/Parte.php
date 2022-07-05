<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parte extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'partes';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detpartes()
    {
        return $this->hasMany('App\Models\Detparte')->orderBy('trazabilidad_id');
    }

    public function detpartecamaras()
    {
        return $this->hasMany('App\Models\Detpartecamara')->orderBy('trazabilidad_id');
    }

    public function detparteproductos()
    {
        return $this->hasMany('App\Models\Detparteproducto')->orderBy('producto_id');
    }

    public function contrata()
    {
    	return $this->belongsTo('App\Models\Contrata');
    }

    public function productoterminado()
    {
    	return $this->belongsTo('App\Models\Productoterminado');
    }
}
