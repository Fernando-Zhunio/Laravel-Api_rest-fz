<?php

namespace App\Http\Controllers;

use App\contacto;
use App\Rules\validar_arreglos_rule;
use App\User;
use App\_palabras_clave;
use App\locale;
use App\oferta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ApiAuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('api_register','searchJobUser');
    }

    public function api_register(Request $request)
    {
        
        // {'name':names,'email':correo,'password':clave,'password_confirm':claveConfirm,
        // 'address':direccion,'local':isLocal,'descripcion':descripcion,'trabajos':jobs,
        // 'contactos':contact,'logo':logo}
        // $request->contactos = json_decode($request->contactos, true);
        // collect($request->contactos);
        //  $request->contactos = 'fernanio';

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'descripcion' => 'required|string|max:500',
            'address' => 'required|string|max:150',
            'local' => 'required|boolean',
            'trabajo' => 'required|string|max:150',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'contactos' => ['required', new validar_arreglos_rule(1, 5)],
            'ofertas' => ['required', new validar_arreglos_rule(1, 5)],
            'palabras' => ['required', new validar_arreglos_rule(1, 3)],
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
                // 'array' => $is,
            ));
        } else {
            if($request->local)
            {
                $validatorCoordenadas = Validator::make($request->all(), [
                    'coordenadas'=>'required'
                ]);
                if ($validatorCoordenadas->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validatorCoordenadas->getMessageBag()->toArray(),
                
                    ));
                 }
            }
            if ($request->hasFile('logo')) {
                $foto = $request->file('logo');
                $namefile = time() . $foto->getClientOriginalName();
                $foto->move(public_path() . '/imagenes/logo/', $namefile);
            }
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'trabajo' => $request->trabajo,
                'descripcion' => $request->descripcion,
                'logo' => $namefile,
                'local'=> $request->local,
                'pais' => 'ecuador',
                'estado_o_provincia' => 'guayas',
                'ciudad' => 'guayaquil',
            ]);
            $user->save();
            $id = $user->id;
            if($request->local)
            $this->insertLocales($id,$request->coordenadas);
            $this->insertarContactos($id,$request->contactos);
            $this->insertarPalabras($id,$request->palabras);
            $this->insertOfertas($id,$request->ofertas);
            return response()->
            json(array(
                'success' => true,
                'message' => 'Successfully created user!',
                'contactos' => $request->contactos,
                'ofertas' => $request->ofertas,
                'palabras' => $request->palabras
            ));
        }
    }

    // private function insertarUser($request, $nameImg)
    // {
    //     $newUser = array([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => $request->password,
    //         'descripcion' => $request->descripcion,
    //         'logo' => $nameImg,
    //         // 'pais'=>$request->pais,
    //         // 'estado_o_provincia'=>$request->provincia,
    //         // 'ciudad'=>$request->ciudad,
    //         'pais' => 'ecuador',
    //         'estado_o_provincia' => 'guayas',
    //         'ciudad' => 'guayaquil',
    //     ]);
    //     User::create($newUser);
    // }
    private function insertarPalabras($id, $palabras)
    {
        $word = json_decode($palabras, true);
        $newPalabras = array();
        $can = count($word);
        // for ($i = 0; $i < $can; $i++) {
        //     $newPalabras[] = ['id_user' => $id, 'palabra' => $word[$i]];
        // }
        foreach ($word as $palabra ) {
            $pila = ['id_user' => $id, 'palabra' => $palabra];
           array_push($newPalabras,$pila); 
        }
        _palabras_clave::insert($newPalabras);
    }

    public function insertarContactos($id, $contactos)
    {
        $contact = json_decode($contactos, true);
        $newContactos = array();
        // $can = count($contact);
      
        foreach ($contact as $contacto ) {
            $pila = ['id_user' => $id, 'contacto' => $contacto['contacto'],'logo'=>$contacto['icon']];
           array_push($newContactos,$pila); 
        }
         contacto::insert($newContactos);
    }

    private function insertOfertas($id, $ofertas)
    {
        $oferts = json_decode($ofertas, true);
        $newOferta = array();
        // $can = count($job);
        foreach ($oferts as $oferta ) {
            $pila = ['id_user' => $id, 'oferta' => $oferta];
           array_push($newOferta,$pila); 
        }
        oferta::insert($newOferta);
    }

    private function insertLocales($id,$coordenadas)
    {
        $coor= json_decode($coordenadas);
        locale::create(['latitud'=> $coor->latitud,'longitud'=> $coor->longitud,'id_user'=>$id]);
    }

    public function getUser(Request $request)
    {    
        $id = $request->user()->id;
        // $contacto = contacto::where('id_user', $id)->get();
        $contacto = $request->user()->contactos;
        // $oferta = oferta::where('id_user', $id)->get();       
        $oferta = $request->user()->ofertas()->get('oferta');       
        $galeria = $request->user()->galerias;
        if($request->user()->local)
        {
            $locales = $request->user()->locales;      
            return response()->json(['user'=>$request->user(),'contactos'=>$contacto,'ofertas'=>$oferta,'galeria'=>$galeria,'locales'=>$locales]);
        }
        else return response()->json(['user'=>$request->user(),'contactos'=>$contacto,'ofertas'=>$oferta,'galeria'=>$galeria]);
    }

    public function logout(Request $request)
    {
        // if (!$this->guard('api')->check()) {
        //     return response([
        //         'message' => 'La sesion no esta activa'
        //     ], 404);
        // }
        if(!Auth::check())
        {
                return response([
                    'message' => 'La sesion no esta activa'
                ], 404);
        }

       return $request->user('api')->token()->revoke();

        Auth::guard()->logout();

        Session::flush();

        Session::regenerate();

        return response([
            'message' => 'Sesion terminada con exito'
        ],200);
    }
}
