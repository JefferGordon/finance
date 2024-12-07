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
        Schema::create('cuenta_por_pagars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained()->onDelete('cascade'); // Relación con empresa
            $table->string('detalle'); // Descripción del gasto
            $table->decimal('monto', 10, 2); // Monto a pagar
            $table->date('fecha_vencimiento'); // Fecha de vencimiento
            $table->boolean('es_recurrente')->default(false);
            $table->integer('cantidad_meses')->nullable();
            $table->enum('estado', ['pendiente', 'pagado'])->default('pendiente'); // Estado de la cuenta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuenta_por_pagars');
    }
};
