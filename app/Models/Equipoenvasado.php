<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipoenvasado extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'equipoenvasados';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detenvasado()
    {
        return $this->hasOne('App\Models\Detenvasado');
    }
}
