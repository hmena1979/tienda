<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destino extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'destinos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detdestinos()
    {
        return $this->hasMany('App\Models\Detdestino');
    }

}
