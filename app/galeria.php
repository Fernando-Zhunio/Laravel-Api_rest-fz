<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class galeria extends Model
{
    protected $fillable= ['imagen','descripcion','id_user'];
    public $timestamps = false;
}
