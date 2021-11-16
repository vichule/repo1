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
    	$persona->apellido1 = $datos->apellido1;
        $persona->apellido2 = $datos->apellido2;
    	$persona->fecha_nacimiento = $datos->fecha_nacimiento;
    	$persona->padre_id = $datos->padre;
        $persona->madre_id = $datos->madre;
        $persona->domicilios_id = $datos->domicilio;


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

     public function listar(){

        $respuesta = ["status" => 1, "msg" => ""];
        try{
            $personas = Persona::all();
            $respuesta['datos'] = $personas;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }
        return response()->json($respuesta);
    }

    public function ver($id){
        $respuesta = ["status" => 1, "msg" => ""];

        //Buscar a la persona
        try{
            $persona = Persona::find($id);
            $persona->makeVisible(['padre_id','madre_id','domicilios_id',id(),'updated_at']);
            $respuesta['datos'] = $persona;
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);

    }

    public function editar(Request $req,$id){

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.


        //Buscar a la persona
        try{
            $persona = Persona::find($id);

            if($persona){

                //VALIDAR LOS DATOS

                if(isset($datos->nombre))
                    $persona->nombre = $datos->nombre;
                if(isset($datos->apellido1))
                    $persona->apellido1 = $datos->apellido1;
                if(isset($datos->apellido2))
                    $persona->apellido2 = $datos->apellido2;
                if(isset($datos->fecha_nacimiento))
                    $persona->fecha_nacimiento = $datos->fecha_nacimiento;
                if(isset($datos->padre_id))
                    $persona->padre_id = $datos->padre;
                if(isset($datos->madre_id))
                    $persona->madre_id = $datos->madre;
                if(isset($datos->domicilios_id))
                    $persona->domicilios_id = $datos->domicilio;


                //Escribir en la bbdd
                    $persona->save();
                    $respuesta['msg'] = "Persona actualizada.";
            }else{
                $respuesta["msg"] = "Persona no encontrada";
                $respuesta["status"] = 0;
            }
        }catch(\Exception $e){
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }

    
}
