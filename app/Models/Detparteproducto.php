<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detparteproducto extends Model
{
    use HasFactory;
    protected $dates = ['deteted_at'];
    protected $table = 'detparteproductos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function parte()
    {
    	return $this->belongsTo('App\Models\Parte');
    }

    public function producto()
    {
    	return $this->belongsTo('App\Models\Producto')->orderBy('nombre');
    }
}
