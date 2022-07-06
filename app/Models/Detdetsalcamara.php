<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detdetsalcamara extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detdetsalcamaras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detsalcamara()
    {
        return $this->belongsTo('App\Models\Detsalcamara');
    }

    public function productoterminado()
    {
        return $this->belongsTo('App\Models\Productoterminado');
    }

    public function dettrazabilidad()
    {
        return $this->belongsTo('App\Models\Dettrazabilidad');
    }
}
