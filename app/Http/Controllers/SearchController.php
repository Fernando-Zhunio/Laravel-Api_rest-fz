<?php

namespace App\Http\Controllers;

use App\_palabras_clave;
use App\contacto;
use App\oferta;
use App\trabajo;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    function __construct()
    {
        $this->middleware('api')->except('serchJob','searchJobUser');
        
    }
    public function searchJob($search)
    {
    //  $trabajo = trabajo::select('name','surname')->where('id', 1)->join('food_ingredient', 'food_ingredient.food_id','=', 'food.id')
    //     ->join('ingredients','ingredient.id','=','food_ingredient.ingredient.id')
    //     ->where('ingredient.title', 'LIKE', '%' . $search . '%');

        // $trabajo = trabajo::select('users.id','users.name','users.descripcion','users.pais','users.ciudad','users.email','users.logo','trabajos.trabajo')
        // ->join('users','users.id','=','trabajos.id_user')->where('trabajos.trabajo', 'LIKE', '%' .$search. '%')->paginate(15);

    // ->join('proveedores','inventarios.proveedor','=','proveedores.id')
    if($search == null || trim($search)== "") return response('error en su solicitud vacia');
    // $busqueda=  _palabras_clave::with('user')->where('palabra', 'LIKE', '%' .'programador'. '%')->get();
    // $busqueda= new _palabras_clave();
    $busqueda = User::select('users.id','email','pais','ciudad','trabajo','descripcion')->join('_palabras_claves','_palabras_claves.id_user','=','users.id')
    ->where('_palabras_claves.palabra', 'LIKE',  $search. '%')->groupBy('users.id')->paginate(20);
        return response()->json($busqueda);
    }

    public function searchJobUser($id)
    {
        $user = User::find($id);
        if ($user === null) {
            // Devuelve un mensaje indicando que no existe un usuario con el id recibido.
            return response()->json('Not fount user',400);
        }
        $job = oferta::where('id_user', $id)->get();
        $palabras = _palabras_clave::where('id_user', $id)->get();
        $contactos = contacto::where('id_user', $id)->get();
        return response()->json(['user'=>$user,'trabajos'=>$job,'palabras'=>$palabras,'contactos'=>$contactos],200);   
    }
}
