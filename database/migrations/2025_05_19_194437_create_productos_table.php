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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('codigo_barra_unitario')->unique();
            $table->string('codigo_barra_embalaje')->unique();
            $table->string('descripcion')->nullable();
            $table->integer('unidades_por_embalaje')->default(1);
            $table->integer('stock_total')->default(0);
            $table->integer('stock_reservado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
