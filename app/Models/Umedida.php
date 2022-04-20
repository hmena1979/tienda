<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Umedida extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'umedidas';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
    protected $appends = ['codigo_nombre'];

    public function getCodigoNombreAttribute()
    {
        return $this->nombre.'('.$this->codigo.')';
    }

    public function producto()
    {
        return $this->hasOne('App\Models\Producto', 'codigo', 'umedida_id');
    }
}
