<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('producto_separado', function (Blueprint $table) {
            $table->id();

            // Primero definimos las columnas
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('nota_venta_id');

            $table->integer('cantidad')->default(0);
            $table->string('responsable');
            $table->timestamps();

            // Luego definimos las relaciones foráneas
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('nota_venta_id')->references('id')->on('pedidos')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_separados');
    }
};
