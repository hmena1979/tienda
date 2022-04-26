<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'clientes';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
    protected $appends = ['numdoc_razsoc'];

    public function getNumdocRazsocAttribute()
    {
        return $this->numdoc. '-'.$this->razsoc;
    }

    // Relaciones Muchos a Uno
    public function rcompras()
    {
    	return $this->hasMany('App\Models\Rcompra');
    }

    public function rventas()
    {
    	return $this->hasMany('App\Models\Rventa');
    }

    public function guia()
    {
    	return $this->hasOne('App\Models\Guia');
    }

    public function transferencias()
    {
    	return $this->hasMany('App\Models\Transferencia');
    }

    public function materiaprima()
    {
        return $this->hasOne('App\Models\Materiaprima');
    }
}
