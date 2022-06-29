<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trazabilidad extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'trazabilidads';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function pproceso()
    {
        return $this->belongsTo('App\Models\Pproceso');
    }

    public function dettrazabilidads()
    {
        return $this->hasMany('App\Models\Dettrazabilidad');
    }

    public function detparte()
    {
        return $this->hasOne('App\Models\Detparte');
    }

    public function detpartecamara()
    {
        return $this->hasOne('App\Models\Detpartecamara');
    }
}
