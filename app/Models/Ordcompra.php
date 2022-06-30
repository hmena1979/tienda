<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ordcompra extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'ordcompras';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];
    protected $appends = ['fecha_id'];

    public function getFechaIdAttribute()
    {
        return $this->fecha. ' | '. str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente');
    }

    public function detordcompras()
    {
        return $this->hasMany('App\Models\Detordcompra');
    }
}
