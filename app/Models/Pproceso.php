<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pproceso extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'pprocesos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function trazabilidads()
    {
        return $this->hasMany('App\Models\Trazabilidad');
    }
    
    public function productoterminado()
    {
    	return $this->belongsTo('App\Models\Productoterminado');
    }
}
