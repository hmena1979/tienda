<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rventa extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'rventas';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detrventa()
    {
        return $this->hasMany('App\Models\Detrventa');
    }

    public function cliente()
    {
    	return $this->belongsTo('App\Models\Cliente');
    	// return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }

    public function monedas()
    {
        return $this->hasOne(Categoria::class, 'codigo', 'moneda')->where('modulo',4);
    }

    public function dettesors()
    {
        return $this->morphMany('App\Models\Dettesor','dettesorable');

    }

    public function detdestino(){
        return $this->belongsTo('App\Models\Detdestino');
    }

    public function ccosto(){
        return $this->belongsTo('App\Models\Ccosto');
    }

    public function getImpuestoSolAttribute()
    {
        if($this->moneda == 'PEN'){
            if($this->tipocomprobante_codigo == '07'){
                return $this->igv * -1;
            }else{
                return $this->igv;
            }
        }
        if($this->moneda == 'USD'){
            if($this->tipocomprobante_codigo == '07'){
                return $this->igv * $this->tc * -1;
            }else{
                return $this->igv * $this->tc;
            }
        }
    }
}
