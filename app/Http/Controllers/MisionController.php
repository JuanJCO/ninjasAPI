<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mision;

class MisionController extends Controller
{

    public function registrarMision(Request $request){
    	$respuesta = "";

    	$datos = $request->getContent();
    	$datos = json_decode($datos);

		if($datos){

			$mision = new Mision();

			$mision->descripcion = $datos->descripcion;
			$mision->cliente_id = $datos->cliente_id;
			$mision->numero_ninjas = $datos->numero_ninjas;
			$mision->urgente = $datos->urgente;
			$mision->pago = $datos->pago;
			$mision->estado = $datos->estado;
			$mision->fecha_finalizacion = $datos->fecha_finalizacion;

			try{
				$mision->save();
				$respuesta = "OK";
			}catch(\Exception $e){
				$respuesta = $e->getMessage();
			}
		}else{
			$respuesta = "Datos Incorrectos.";
		}
		return response($respuesta);
    }

	public function listaMisiones(){

		$misiones = Mision::orderBy('Urgente','DESC')->orderBy('created_at','ASC')->get();
        $resultado = [];

        foreach ($misiones as $mision) {

            $resultado[] = [
 				"id" => $mision->id,
				"descripcion" => $mision->descripcion,
				"cliente ID" => $mision->cliente_id,
				"numero_ninjas" => $mision->numero_ninjas,
				"urgente" => $mision->urgente,
				"pago" => $mision->pago,
				"estado" => $mision->estado,
				"fecha_finalizacion" => $mision->fecha_finalizacion,
				"fecha_registro" => $mision->created_at,
            ];
        }
        return response()->json($resultado);
	}

	public function verMision($id){

		$mision = Mision::find($id);

		if($mision){

			$asignaciones = [];

			foreach ($mision->asignaciones as $asignacion) {
				$asignaciones[] = [
				"ninja_id" => $asignacion->ninja_id,
				"ninja_nombre" => $asignacion->ninja->nombre,
				];
			};
			
			$datosMision = [	
				"ID" => $mision->id,
				"descripcion" => $mision->descripcion,
				"numero_ninjas" => $mision->numero_ninjas,
				"urgente" => $mision->urgente,
				"pago acordado" => $mision->pago,
				"estado" => $mision->estado,
				"fecha_finalizacion" => $fecha_finalizacion,
				"ninjas asignados" => $asignaciones,
				];

			return response()->json($datosMision);		
		}		
		return response("Cliente no encontrado.");
	}	

	public function filtrarEstado($estado){

		$misiones = Mision::orderBy('Urgente','DESC')->orderBy('created_at','ASC')->get();
		$busqueda = [];

		foreach($misiones as $mision) {

				if ($mision->estado == $estado){
					$busqueda[] = [
						"nombre" => $mision->id,
						"cliente_id" => $mision->cliente_id,
						"numero_ninjas" => $mision->numero_ninjas,
						"prioridad" => $mision->urgente,
						"estado" => $mision->estado,
						"fecha_finalizacion" => $mision->fecha_finalizacion,
						"fecha_registrio" => $mision->created_at
					];
				}
		}
		return $busqueda;
	}

	public function filtrarCodigoCliente($clienteId){

		$misiones = Mision::orderBy('Urgente','DESC')->orderBy('created_at','ASC')->get();
		$busqueda = [];

		foreach($misiones as $mision) {

				if ($mision->cliente_id == $clienteId){
					$busqueda[] = [
						"nombre" => $mision->id,
						"cliente_id" => $mision->cliente_id,
						"numero_ninjas" => $mision->numero_ninjas,
						"prioridad" => $mision->urgente,
						"estado" => $mision->estado,
						"fecha_finalizacion" => $mision->fecha_finalizacion,
						"fecha_registrio" => $mision->created_at
					];
				}
		}
		return $busqueda;
	}


	/*        Schema::create('misions', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->foreignId('cliente_id');
            $table->unsignedInteger('numero_ninjas');
            $table->boolean('urgente');
            $table->text('pago');
            $table->enum('estado', ['Pendiente', 'En Curso', 'Completado', 'Fallado']);
            $table->date('fecha_finalizacion');
            $table->timestamps();
        });*/
}
