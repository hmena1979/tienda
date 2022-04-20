<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tesoreria extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'tesorerias';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    // Relación Uno a Muchos
    public function dettesors()
    {
    	return $this->hasMany('App\Models\Dettesor');
    }

    // Relación  Muchos a Uno
    public function cuenta()
    {
    	return $this->belongsTo('App\Models\Cuenta');
    	// return $this->hasOne('App\Models\Cuenta','id','cuenta_id');
    	// return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }

    public function mediopagos()
    {
        return $this->hasOne(Categoria::class, 'codigo', 'mediopago')->where('modulo',5);
    }
}
