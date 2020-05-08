<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','trabajo','descripcion','logo','local','pais','estado_o_provincia','ciudad'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ofertas()
    {
        return $this->hasMany('App\oferta','id_user');              
    }

    public function ofertasForSearch()
    {
        return $this->hasMany('App\oferta','id_user')->select('oferta');              
    }

    public function contactos()
    {
        return $this->hasMany('App\contacto','id_user');              
    }

    public function contactosForSearch()
    {
        return $this->hasMany('App\contacto','id_user')->select('contacto','logo as icon');              
    }

    public function galerias()
    {
        return $this->hasMany('App\galeria','id_user');              
    }

    public function galeriaForSearch()
    {
        return $this->hasMany('App\galeria','id_user')->select('descripcion','imagen');              
    }

    public function locales()
    {
        return $this->hasMany('App\locale','id_user')->select('latitud','longitud');              
    }
}
