<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empacopiadora extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'empacopiadoras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function acopiadors()
    {
        return $this->hasMany('App\Models\Acopiador');
    }

    public function materiaprima()
    {
        return $this->hasOne('App\Models\Materiaprima');
    }
}
