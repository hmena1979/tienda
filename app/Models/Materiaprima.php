<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materiaprima extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'materiaprimas';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente');
    }

    public function transportista(){
        return $this->belongsTo('App\Models\Transportista');
    }

    public function chofer(){
        return $this->belongsTo('App\Models\Chofer');
    }

    public function camara(){
        return $this->belongsTo('App\Models\Camara');
    }

    public function empacopiadora(){
        return $this->belongsTo('App\Models\Empacopiadora');
    }

    public function acopiador(){
        return $this->belongsTo('App\Models\Acopiador');
    }

    public function embarcacion(){
        return $this->belongsTo('App\Models\Embarcacion');
    }

    public function muelle(){
        return $this->belongsTo('App\Models\Muelle');
    }

    public function producto(){
        return $this->belongsTo('App\Models\Producto');
    }

    public function detmateriaprimas()
    {
        return $this->hasMany('App\Models\Detmateriaprima');
    }
}
