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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('nota_venta');
            $table->string('responsable');
            $table->string('codigo_qr')->nullable(); // Código QR asociado al pedido
            $table->integer('estado_qr')->default(0); // Estado del código QR (0: no generado, 1: generado)
            $table->string('estado')->default('en_proceso'); // en_proceso, completado, despachado, entregado
            $table->dateTime('fecha_separacion')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
            $table->string('cliente'); // Nombre del cliente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
