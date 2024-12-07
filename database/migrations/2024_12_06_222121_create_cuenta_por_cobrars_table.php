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
        Schema::create('cuenta_por_cobrars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained()->onDelete('cascade'); // Relación con empresa
            $table->string('detalle'); // Descripción del ingreso
            $table->decimal('monto', 10, 2); // Monto a cobrar
            $table->date('fecha_vencimiento'); // Fecha de vencimiento
            $table->boolean('es_recurrente')->default(false); // Indica si es recurrente
            $table->integer('cantidad_meses')->nullable(); // Número de meses en caso de ser recurrente
            $table->enum('estado', ['pendiente', 'cobrado'])->default('pendiente'); // Estado de la cuenta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuenta_por_cobrars');
    }
};
