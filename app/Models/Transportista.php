<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transportista extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'transportistas';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function chofers()
    {
        return $this->hasMany('App\Models\Chofer');
    }

    public function camaras()
    {
        return $this->hasMany('App\Models\Camara');
    }

    public function materiaprima()
    {
        return $this->hasOne('App\Models\Materiaprima');
    }

    public function embarque()
    {
        return $this->hasOne('App\Models\Embarque');
    }

    public function salcamara()
    {
        return $this->hasOne('App\Models\Salcamara');
    }
}
