<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'pedidos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
    
    public function detpedidos()
    {
        return $this->hasMany('App\Models\Detpedido');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function detdestino()
    {
        return $this->belongsTo('App\Models\Detdestino');
    }
}
