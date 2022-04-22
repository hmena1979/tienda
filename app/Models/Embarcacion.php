<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Embarcacion extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'embarcacions';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
    protected $appends = ['nombre_matricula'];

    public function getNombreMatriculaAttribute()
    {
        return $this->nombre.' | '.$this->matricula;
    }

    
    public function materiaprima()
    {
        return $this->hasOne('App\Models\Materiaprima');
    }
}
