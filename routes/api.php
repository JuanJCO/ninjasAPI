<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NinjaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MisionController;
use App\Http\Controllers\AsignacionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('ninjas')->group(function () {
	Route::post('/registrar',[NinjaController::class,"registrarNinja"]);
	Route::post('/baja/{id}',[NinjaController::class,"bajaNinja"]);
	Route::get('/ninja/{id}',[NinjaController::class,"verNinja"]);
	Route::get('/filtrarNombre/{nombre}', [NinjaController::class, "filtrarNombre"]);
    Route::get('/filtrarEstado/{estado}', [NinjaController::class, "filtrarEstado"]);
	Route::get('/', [NinjaController::class, "listaNinjas"]);
});

Route::prefix('clientes')->group(function () {
    Route::post('/registrar',[ClienteController::class,"registrarCliente"]);
    Route::get('/cliente/{id}',[ClienteController::class,"verCliente"]);
    Route::get('/',[ClienteController::class,"listaClientes"]);
});

Route::prefix('misiones')->group(function () {
    Route::post('/registrar',[MisionController::class,"registrarMision"]);
    Route::get('/mision/{id}',[MisionController::class,"verMision"]);
    Route::get('/',[MisionController::class,"listaMisiones"]);
    Route::get('/filtrarEstado/{estado}', [MisionController::class, "filtrarEstado"]);
    Route::get('/filtrarCliente/{clienteId}', [MisionController::class, "filtrarCodigoCliente"]);
});

Route::prefix('asignaciones')->group(function () {
    Route::post('/registrar',[AsignacionController::class,"asignar"]);
});