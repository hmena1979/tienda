<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmpdetguia extends Model
{
    use HasFactory;
    protected $dates = ['deteted_at'];
    protected $table = 'tmpdetguias';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto');
    }
}
