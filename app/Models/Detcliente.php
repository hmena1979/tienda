<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detcliente extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detclientes';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function cliente()
    {
    	return $this->belongsTo('App\Models\Cliente');
    }

    public function banco()
    {
    	return $this->belongsTo('App\Models\Banco');
    }

    public function detmasivo()
    {
    	return $this->hasOne('App\Models\Detmasivo');
    }
}
