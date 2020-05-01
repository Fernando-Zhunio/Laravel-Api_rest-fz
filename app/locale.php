<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class locale extends Model
{
    protected $fillable= ['latitud','longitud','id_user'];
    public $timestamps = false;

}
