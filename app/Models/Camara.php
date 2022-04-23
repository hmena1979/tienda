<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camara extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'camaras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
    protected $appends = ['marca_placa'];

    public function getMarcaPlacaAttribute()
    {
        return $this->marca.' '.$this->placa;
    }

    public function transportista(){
        return $this->belongsTo('App\Models\Transportista');
    }

    public function materiaprima()
    {
        return $this->hasOne('App\Models\Materiaprima');
    }
}
