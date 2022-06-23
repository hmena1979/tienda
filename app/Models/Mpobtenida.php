<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mpobtenida extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'mpobtenidas';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function producto(){
        return $this->belongsTo('App\Models\Producto');
    }

    public function despiece()
    {
    	return $this->belongsTo('App\Models\Despiece');
    }

}
