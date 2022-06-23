<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detpartecamara extends Model
{
    use HasFactory;
    protected $dates = ['deteted_at'];
    protected $table = 'detpartecamaras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function parte()
    {
    	return $this->belongsTo('App\Models\Parte');
    }

    public function dettrazabilidad()
    {
    	return $this->belongsTo('App\Models\Dettrazabilidad');
    }
}
