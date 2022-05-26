<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detpedido extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detpedidos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function pedido(){
        return $this->belongsTo('App\Models\Pedido');
    }

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto');
    }
}
