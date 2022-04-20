<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dettesor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'dettesors';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    // Relación Polimorfica
    public function dettesorable()
    {
        return $this->morphTo();
    }

    public function tesoreria()
    {
    	return $this->belongsTo('App\Models\Tesoreria');
    	// return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }
}
