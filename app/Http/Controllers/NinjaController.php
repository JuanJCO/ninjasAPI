<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ninja;

class NinjaController extends Controller
{

	//Registra el ninja
    public function registrarNinja(Request $request){

    	$respuesta = "";

    	$datos = $request->getContent();
    	$datos = json_decode($datos);

		if($datos){

			$ninja = new Ninja();

			$ninja->nombre = $datos->nombre;
			$ninja->rango = $datos->rango;
			$ninja->habilidades = $datos->habilidades;
			$ninja->estado = $datos->estado;			

			try{
				$ninja->save();
				$respuesta = "OK";
			}catch(\Exception $e){
				$respuesta = $e->getMessage();
			}
		}else{
			$respuesta = "Datos Incorrectos.";
		}
		return response($respuesta);
    }

    //Cambia el Estado de un ninja a Retirado a través del ID
    public function bajaNinja($id){

		$respuesta = "";
		$ninja = Ninja::find($id);

		if($ninja){
			$ninja->estado = 'Retirado';
			try{
				$ninja->save();
					$respuesta = "OK";
				}catch(\Exception $e){
					$respuesta = $e->getMessage();
				}
		}else{
			$response = "No se ha encontrado el ninja";
		}
		return response($respuesta);
	}

	//Muestra la información completa del ninja por su ID 
	public function verNinja($id){

		$ninja = Ninja::find($id);

		if($ninja){

			$asignaciones = [];

			foreach ($ninja->asignaciones as $asignacion){
				$asignaciones[] = [

				];
			} 
				
					"Id" => $ninja->id,
					"Nombre" => $ninja->nombre,
					"Rango" => $ninja->rango,
					"Habilidades" => $ninja->habilidades,
					"Estado" => $ninja->estado,
					"Fecha Registro" => $ninja->created_at,
				
			);
		}


		return response("Ninja no encontrado");
	}

	//Muestra el listado de todos los ninjas con la información relevante
	public function listaNinjas(){

		$ninjas = Ninja::all();
        $resultado = [];

        foreach ($ninjas as $ninja) {

            $resultado[] = [
				"Nombre" => $ninja->nombre,
				"Rango" => $ninja->rango,
				"Estado" => $ninja->estado,
				"Fecha Registro" => $ninja->created_at,
            ];
        }
        return response()->json($resultado);

        //FILTRO NOMBRE Y ESTADO 
        //FILTRO NOMBRE Y ESTADO 
        //FILTRO NOMBRE Y ESTADO 
        //FILTRO NOMBRE Y ESTADO 
        //FILTRO NOMBRE Y ESTADO 
        //FILTRO NOMBRE Y ESTADO 
	}

	//Filtrar por Nombre y Estado
	public function filtrarNinja(Request $request){

        $ninjaClass = Ninja::class;


        if($request->request->get('nombre')){
            $ninjaClass = $ninjaClass::where('nombre', 'like', '%' . $request->request->get('nombre') . '%');
        }
        if($request->request->get('estado')){
            $ninjaClass = $ninjaClass::where('estado', $request->request->get('estado'));
        }

    	$ninjas = $ninjaClass->get();

        $resultado = [];

        foreach ($ninjas as $ninja) {
            $resultado[] = [
                "nombre" => $ninja->nombre,
                "fecha_registro" => $ninja->created_at,
                "rango" => $ninja->rango,
                "estado" => $ninja->estado
            ];
        }
        return response()->json($resultado);
    }
}
