<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rcompra extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'rcompras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detingresos()
    {
        return $this->hasMany('App\Models\Detingreso');
    }

    public function detrcompras()
    {
        return $this->hasMany('App\Models\Detrcompra');
    }

    public function detmasivo()
    {
        return $this->hasOne('App\Models\Detmasivo');
    }

    // Relaciones Uno a Muchos Inversa
    public function cliente()
    {
    	return $this->belongsTo('App\Models\Cliente');
    	// return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }

    public function monedas()
    {
        return $this->hasOne(Categoria::class, 'codigo', 'moneda')->where('modulo',4);
    }

    // Relación Polimorfica
    public function dettesors()
    {
        return $this->morphMany('App\Models\Dettesor','dettesorable');
    }

    public function getImpuestoSolAttribute()
    {
        if($this->moneda == 'PEN'){
            if($this->tipocomprobante_codigo == '07'){
                return $this->impuesto * -1;
            }else{
                return $this->impuesto;
            }
        }
        if($this->moneda == 'USD'){
            if($this->tipocomprobante_codigo == '07'){
                return $this->impuesto * $this->tc * -1;
            }else{
                return $this->impuesto * $this->tc;
            }
        }
    }

    public function getRentaSolAttribute()
    {
        if($this->moneda == 'PEN'){
            return $this->renta;
        }
        if($this->moneda == 'USD'){
            return $this->renta * $this->tc;
        }
    }
}
