<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id')->comment('ID del producto relacionado al ingreso o egreso');
            $table->string('documento')->nullable()->comment('Documento relacionado al ingreso o egreso');
            $table->enum('tipo_ingreso', [1, 2, 3])->comment('1: Ingreso, 2: Preparado, 3: Egreso');
            $table->integer('cantidad')->default(0)->comment('Cantidad de producto ingresado o egresado');
            $table->string('responsable')->comment('Nombre del responsable del ingreso o egreso');
            $table->timestamp('fecha_ingreso')->useCurrent()->comment('Fecha y hora del ingreso o egreso');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardexes');
    }
};
