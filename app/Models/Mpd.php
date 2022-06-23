<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpd extends Model
{
    use HasFactory;
    protected $dates = ['deteted_at'];
    protected $table = 'mpds';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
    
    public function dettrazabilidad()
    {
        return $this->hasOne('App\Models\Dettrazabilidad');
    }
}
