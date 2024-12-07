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
        Schema::create('letras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_por_cobrar_id')->constrained()->onDelete('cascade'); // Relación con la cuenta por cobrar
            $table->decimal('monto', 10, 2); // Monto de la letra
            $table->date('fecha_vencimiento'); // Fecha de vencimiento de la letra
            $table->enum('estado', ['pendiente', 'pagado'])->default('pendiente'); // Estado de la letra
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letras');
    }
};
