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

			foreach ($ninja->asignaciones as $asignacion) {
				$asignaciones[] = [
				"mision_id" => $asignacion->mision_id,
				"mision_nombre" => $asignacion->mision->nombre,
				"mision_fecha" => $asignacion->mision->created_at,
				"mision_estado" => $asignacion->mision->estado,
				];
			};
			
			$datosNinja = [	
				"ID" => $ninja->id,
				"nombre" => $ninja->nombre,
				"rango" => $ninja->rango,
				"habilidades" => $ninja->habilidades,
				"estado" => $ninja->estado,
				"misiones_asignadas" => $asignaciones,
				];

			return response()->json($datosNinja);		
		}		
		return response("Cliente no encontrado.");
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


	public function filtrarNombre($nombre){

		$ninjas = Ninja::all();
		$busqueda = [];

		foreach($ninjas as $ninja) {

				if ($ninja->nombre == $nombre){
					$busqueda[] = [
						"nombre" => $ninja->nombre,
						"rango" => $ninja->rango,
						"habilidades" => $ninja->habilidades,
						"estado" => $ninja->estado,
					];
				}
		}
		return $busqueda;
	}

	public function filtrarEstado($estado){
		
		$ninjas = Ninja::all();
		$busqueda = [];

		foreach($ninjas as $ninja) {

				if ($ninja->estado == $estado){
					$busqueda[] = [
						"nombre" => $ninja->nombre,
						"rango" => $ninja->rango,
						"habilidades" => $ninja->habilidades,
						"estado" => $ninja->estado,
					];
				}
		}
		return $busqueda;
	}
}
