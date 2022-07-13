<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'countries';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function embarque(){
        return $this->hasOne('App\Models\Embarque');
    }
}
