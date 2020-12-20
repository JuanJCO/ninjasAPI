<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
	//Da de alta el cliente
    public function registrarCliente(Request $request){

    	$respuesta = "";

    	$datos = $request->getContent();
    	$datos = json_decode($datos);

		if($datos){

			$cliente = new Cliente();

			$cliente->codigo_secreto = $datos->codigo_secreto;
			$cliente->VIP = $datos->VIP;			

			try{
				$cliente->save();
				$respuesta = "OK";
			}catch(\Exception $e){
				$respuesta = $e->getMessage();
			}
		}else{
			$respuesta = "Datos Incorrectos.";
		}
		return response($respuesta);
    }

    //Edita el CÓDIGO SECRETO y VIP del cliente
    public function editarCliente(Request $request, $id){

		$respuesta = "";

		$datos = $request->getContent();
		$datos = json_decode($datos);

		$cliente = Cliente::find($id);

		if($cliente){
			$cliente->codigo_secreto = $datos->codigo_secreto;
			$cliente->VIP = $datos->VIP;
			try{
				$cliente->save();
					$respuesta = "OK";
				}catch(\Exception $e){
					$respuesta = $e->getMessage();
				}
		}else{
			$response = "No se ha encontrado el cliente";
		}
		return response($respuesta);

    }

    //Muestra toda la información de todos los clientes
    public function listaClientes(){

		$clientes = Cliente::all();
        $resultado = [];

        foreach ($clientes as $cliente) {

            $resultado[] = [
 				"id" => $cliente->id,
 				"VIP" => $cliente->VIP,
 				"codigo_secreto" => $cliente->codigo_secreto,
 				"fecha_registro" => $cliente->created_at,
            ];
        }
        return response()->json($resultado);
	}

	//Consultar un solo cliente por su ID
	public function verCliente($id){

		$cliente = Cliente::find($id);

		if($cliente){

			$misiones = [];

			foreach ($cliente->misiones as $mision) {
				$misiones[] = [
				"id" => $mision->id,
				"fecha_mision" => $mision->created_at,
				"estado mision" => $mision->prioridad,
				"pago mision" => $mision->pago,
				];
			};
			
			$datosCliente = [	
				"ID" => $cliente->id,
				"VIP" => $cliente->VIP,
				"Código Secreto" => $cliente->codigo_secreto,
				"Fecha Registro" => $cliente->created_at,
				"misiones" => $misiones,
				];

			return response()->json($datosCliente);		
		}		
		return response("Cliente no encontrado.");
	}
}
