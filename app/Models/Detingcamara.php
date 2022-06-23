<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detingcamara extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detingcamaras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function ingcamara()
    {
    	return $this->belongsTo('App\Models\Ingcamara');
    }

    public function dettrazabilidad()
    {
    	return $this->belongsTo('App\Models\Dettrazabilidad');
    }

}
