<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;
    protected $dates = ['deteted_at'];
    protected $table = 'provincias';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
}
