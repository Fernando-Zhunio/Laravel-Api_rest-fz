<?php

namespace App\Http\Controllers;

use App\contacto;
use App\galeria;
use App\oferta;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UserUpdateController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api');
        // ->except('api_register','searchJobUser');

    }
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }
    public function storeImagen(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            // 'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'descripcion' => 'required|string|max:100'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ));
        } 
        else
        {
            if ($request->hasFile('imagen')) {
                $foto = $request->file('imagen');
                $namefile = time() . $foto->getClientOriginalName();
                $foto->move(public_path() . '/imagenes/Galeria/', $namefile);
            }
            // $dataInsert =['imagen'=>$namefile,'descripcion'=>$request->descripcion,'id_user'=>$request->user()->id];
            $galeria= new galeria();
            $galeria->imagen= $namefile;
            $galeria->descripcion= $request->descripcion;
            $galeria->id_user= $request->user()->id;
            $galeria->save();
            // $galeria = $request->user()->galerias;       
            return response()->json(array(
                'success' => true,
                'imagen' =>$namefile,
                'descripcion'=>$request->descripcion,
                'id'=> $galeria->id
            ));
        }
    }


 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDescripcion(Request $request)
    {
       $id= $request->user()->id;
       $descripcion= User::find($id);
       $descripcion->descripcion= $request->descripcion;
       $descripcion->save();
       return response()->json(array(
           'success'=>true,
           'response'=> $request->descripcion
       ));
    }
    public function updateOfertas(Request $request)
    {
        $request->user()->ofertas()->delete();
        $oferta = $request->ofertas;
        $idUser = $request->user()->id;
        // $authController = new ApiAuthenticationController();
        // $authController->insertOfertas($idUser,$oferta);
        $this->insertOfertas($idUser,$oferta);
        $ofertas= $request->user()->ofertas()->get('oferta');
        return response()->json(array(
            'success'=>true,
            'ofertas'=>$ofertas
        ));
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

    public function updateContactos(Request $request)
    {
        $request->user()->contactos()->delete();
        $contactos = $request->contactos;
        $id = $request->user()->id;
        $this->insertarContactos($id,$contactos);
        // $contact= $request->user()->contactos;

        return response()->json(array(
            'success'=>true,
            // 'contactos'=>$contact
        ));
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
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImagen($id)
    {
        $img= galeria::find($id);
        if(!$img)
           return response()->json(array(
               'success'=>false,
               'data'=>'No encontrado'
           ));
        $image_path = "/imagenes/Galeria".$img->imagen;  // Value is not URL but directory file path
        if(File::exists($image_path))File::delete($image_path);
         galeria::destroy($id);
        return response()->json(array(
            'success'=>true,
            'data'=>'Eliminado con exito'
        ));
    }
}
