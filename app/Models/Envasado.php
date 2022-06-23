<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Envasado extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'envasados';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detenvasados()
    {
        return $this->hasMany('App\Models\Detenvasado');
    }

    public function supervisor()
    {
    	return $this->belongsTo('App\Models\Supervisor');
    }
}
