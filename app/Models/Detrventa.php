<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detrventa extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detrventas';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function rventa(){
        return $this->belongsTo('App\Models\Rventa');
    }

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto');
    }
}
