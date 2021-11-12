<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;

class PersonasController extends Controller
{
    //
    public function crear(Request $req){

    	$respuesta = ["status" => 1, "msg" => ""];
    	
    	$datos = $req->getContent();

    	//VALIDAR EL JSON

    	$datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parametro para que en su lugar lo devuelva como array.

    	//print_r($datos); porque es un objeto no se puede usar print normal porque es para cadenas.

    	//VALIDAR LOS DATOS

    	$persona = new Persona();

    	$persona->nombre = $datos->nombre;
    	$persona->dni = $datos->dni;
    	$persona->telefono = $datos->telefono;
    	$persona->direccion = $datos->direccion;

    	//if (isset($datos->direccion))
    	//	$persona->email = $datos->email;

    	//Escribir en la bbdd
    	try{
    		$persona->save();
    		$respuesta['msg'] = "Persona guardada con id ".$persona->id;

    	}catch(\Exception $e){
    		$respuesta['status'] = 0;
    		$respuesta['msg'] = "Se ha producido un error ".$e->getMessage();
    	}
    	
    	return response()->json($respuesta);
    }

    public function borrar($id){

    	$respuesta = ["status" => 1, "msg" => ""];

    	//BUscar a la persona
    	$persona = Persona::find($id);

    	if($persona){
    		try{
    		$persona->delete();
    		$respuesta['msg'] = "Persona borrada";

    	}catch(\Exception $e){
    		$respuesta['status'] = 0;
    		$respuesta['msg'] = "Se ha producido un error ".$e->getMessage();
    	}

    	}else{
    		$respuesta["msg"] = "Persona no encontrada";
    		$respuesta["status"] = 0;
    	}

    	return response()->json($respuesta);

    }

    
}
