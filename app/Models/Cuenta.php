<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuenta extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'cuentas';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    // Relación Uno a Muchos
    public function tesorerias()
    {
    	return $this->hasMany('App\Models\Tesoreria');
    }

    public function banco()
    {
    	return $this->belongsTo('App\Models\Banco');
    }
}
