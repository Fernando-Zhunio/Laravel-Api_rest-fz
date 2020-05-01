<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _palabras_clave extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User','id_user','id');              
    }
}
