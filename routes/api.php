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
	Route::get('/filtrar', [NinjaController::class, "filtrarNinja"]);
	Route::get('/', [NinjaController::class, "listaNinjas"]);
});

Route::prefix('clientes')->group(function () {
    Route::post('/registrar',[ClienteController::class,"registrarCliente"]);
    Route::post('/editar/{id}',[ClienteController::class,"editarCliente"]);
    Route::get('/cliente/{id}',[ClienteController::class,"verCliente"]);
    Route::get('/',[ClienteController::class,"listaClientes"]);
});

Route::prefix('misiones')->group(function () {
    Route::post('/registrar',[MisionController::class,"registrarMision"]);
    Route::post('/editar/{id}',[MisionController::class,"editarMision"]);
    Route::get('/mision/{id}',[MisionController::class,"verMision"]);
    Route::get('/',[MisionController::class,"listaMisiones"]);
    Route::get('/filtro',[MisionController::class,"filtroMision"]);
});

Route::prefix('asignaciones')->group(function () {
    Route::post('/registrar',[AsignacionController::class,"asignar"]);
});