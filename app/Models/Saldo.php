<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $dates = ['deteted_at'];
    protected $table = 'saldos';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
}
