<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salcamara extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'salcamaras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detsalcamaras()
    {
        return $this->hasMany('App\Models\Detsalcamara');
    }

    public function supervisor()
    {
    	return $this->belongsTo('App\Models\Supervisor');
    }

    public function transportista()
    {
    	return $this->belongsTo('App\Models\Transportista');
    }
}
