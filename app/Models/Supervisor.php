<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supervisor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'supervisors';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function envasado()
    {
        return $this->hasOne('App\Models\Envasado');
    }

    public function ingcamara()
    {
        return $this->hasOne('App\Models\Ingcamara');
    }
}
