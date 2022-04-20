<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banco extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'bancos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function cuenta()
    {
    	return $this->hasOne('App\Models\Cuenta');
    }
}
