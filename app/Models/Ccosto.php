<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ccosto extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'ccostos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function rventa(){
        return $this->hasOne('App\Models\Rventa');
    }

    public function detrcompra(){
        return $this->hasOne('App\Models\detrcompra');
    }


}
