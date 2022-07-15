<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detsolcompra extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detsolcompras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function solcompra(){
        return $this->belongsTo('App\Models\Solcompra');
    }

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto');
    }
}
