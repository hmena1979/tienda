<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guia extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deteted_at'];
    protected $table = 'guias';
    protected $hidden = ['created_at','updated_at'];
    protected $guarded = [];

    public function detguias()
    {
        return $this->hasMany('App\Models\Detguia');
    }

    public function cliente()
    {
    	return $this->belongsTo('App\Models\Cliente');
    	// return $this->hasOne('App\Models\Cliente', 'id', 'cliente_id');
    }

    public function docrelacionado()
    {
        return $this->hasOne('App\Models\Categoria', 'codigo', 'docrelacionado_id')->whereIn('modulo',['0','8']);
    }

    public function motivotraslado()
    {
        return $this->hasOne('App\Models\Categoria', 'codigo', 'motivotraslado_id')->whereIn('modulo',['0','9']);
    }

    public function modalidadtraslado()
    {
        return $this->hasOne('App\Models\Categoria', 'codigo', 'modalidadtraslado_id')->whereIn('modulo',['0','10']);
    }
}
