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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id') // Agregar el campo empresa_id
                ->constrained('empresas') // Relación con la tabla empresas
                ->onDelete('cascade'); // Borrar las transacciones al eliminar la empresa
            $table->foreignId('transaction_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('month_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
