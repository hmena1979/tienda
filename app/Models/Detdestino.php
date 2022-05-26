<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detdestino extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detdestinos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function destino()
    {
        return $this->belongsTo('App\Models\Destino');
    }

    public function detrcompra(){
        return $this->hasOne('App\Models\detrcompra');
    }

    public function rventa(){
        return $this->hasOne('App\Models\Rventa');
    }

    public function pedido(){
        return $this->hasOne('App\Models\Pedido');
    }
}
