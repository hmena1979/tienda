<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detcotizacion extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'detcotizacions';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function cotizacion(){
        return $this->belongsTo('App\Models\Cotizacion');
    }

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto');
    }
}
