<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transferencia extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'transferencias';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function dettesors()
    {
        return $this->morphMany('App\Models\Dettesor','dettesorable');
    }

    public function cliente()
    {
    	return $this->belongsTo('App\Models\Cliente');
    	// return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }   

    public function abono()
    {
    	return $this->hasOne('App\Models\Cuenta', 'id', 'abono_id');
    	// return $this->hasOne('App\Models\Cuenta','id','cuenta_id');
    	// return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }

    public function cargo()
    {
    	return $this->hasOne('App\Models\Cuenta', 'id', 'cargo_id');
    	// return $this->hasOne('App\Models\Cuenta','id','cuenta_id');
    	// return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }
}
