<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detingreso extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detingresos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function rcompra(){
        return $this->belongsTo('App\Models\Rcompra');
    }

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto');
    }
}
