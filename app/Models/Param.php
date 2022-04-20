<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    use HasFactory;
    protected $dates = ['deteted_at'];
    protected $table = 'params';
    protected $hidden = ['created_at','updated_at'];
}
