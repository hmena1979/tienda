<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detguia extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detguias';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function guia()
    {
        return $this->belongsTo('App\Models\Guia');
    }

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto');
    }
}
