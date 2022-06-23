<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingcamara extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'ingcamaras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detingcamaras()
    {
        return $this->hasMany('App\Models\Detingcamara');
    }

    public function supervisor()
    {
    	return $this->belongsTo('App\Models\Supervisor');
    }
}
