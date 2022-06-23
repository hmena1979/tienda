<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detenvasado extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detenvasados';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function envasado()
    {
    	return $this->belongsTo('App\Models\Envasado');
    }

    public function dettrazabilidad()
    {
    	return $this->belongsTo('App\Models\Dettrazabilidad');
    }

    public function equipoenvasado()
    {
    	return $this->belongsTo('App\Models\Equipoenvasado');
    }
}
