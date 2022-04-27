<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Masivo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'masivos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detmasivos()
    {
        return $this->hasMany('App\Models\Detmasivo');
    }

    public function cuenta()
    {
    	return $this->belongsTo('App\Models\Cuenta');
    }


}
