<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detsalcamara extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detsalcamaras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function salcamara()
    {
        return $this->belongsTo('App\Models\Salcamara');
    }

    public function detdetsalcamaras()
    {
        return $this->hasMany('App\Models\Detdetsalcamara');
    }

    public function dettrazabilidad()
    {
    	return $this->belongsTo('App\Models\Dettrazabilidad');
    }
}
