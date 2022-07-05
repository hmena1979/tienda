<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productoterminado extends Model
{
    use HasFactory;
    protected $dates = ['deteted_at'];
    protected $table = 'productoterminados';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detdetsalcamara()
    {
        return $this->hasOne('App\Models\Detdetsalcamara');
    }

    public function parte()
    {
        return $this->belongsTo('App\Models\Parte');
    }

    public function pproceso()
    {
        return $this->belongsTo('App\Models\Pproceso');
    }

    public function trazabilidad()
    {
        return $this->belongsTo('App\Models\Trazabilidad');
    }

    public function dettrazabilidad()
    {
        return $this->belongsTo('App\Models\Dettrazabilidad');
    }
}
