<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('misions', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->foreignId('cliente_id');
            $table->unsignedInteger('numero_ninjas');
            $table->boolean('urgente');
            $table->text('pago');
            $table->enum('estado', ['Pendiente', 'En Curso', 'Completado', 'Fallado']);
            $table->date('fecha_finalizacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('misions');
    }
}
