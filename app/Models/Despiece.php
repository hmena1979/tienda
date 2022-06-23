<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Despiece extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'despieces';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detdespieces()
    {
    	return $this->hasMany('App\Models\Detdespiece');
    }

    public function mpobtenida()
    {
    	return $this->hasOne('App\Models\Mpobtenida');
    }
}
