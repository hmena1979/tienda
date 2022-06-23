<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dettrazabilidad extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'dettrazabilidads';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
    protected $appends = ['mpd_codigo'];

    public function getMpdCodigoAttribute()
    {

        return $this->mpd->nombre. ' '.$this->codigo;
    }

    public function trazabilidad()
    {
        return $this->belongsTo('App\Models\Trazabilidad');
    }

    public function mpd()
    {
        return $this->belongsTo('App\Models\Mpd');
    }

    public function detenvasado()
    {
        return $this->hasOne('App\Models\Detenvasado');
    }

    public function detparte()
    {
        return $this->hasOne('App\Models\Detparte');
    }
}
