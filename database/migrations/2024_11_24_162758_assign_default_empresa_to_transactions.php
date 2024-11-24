<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Empresa;
use App\Models\Transaction;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Crea una empresa por defecto si no existe
        $defaultEmpresa = Empresa::firstOrCreate(['nombre' => 'Empresa Default', 'tipo' => 'juridica']);

        // Asigna esta empresa a todas las transacciones existentes
        Transaction::whereNull('empresa_id')->update(['empresa_id' => $defaultEmpresa->id]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Puedes deshacer esto si es necesario
        Transaction::where('empresa_id', Empresa::where('nombre', 'Empresa Default')->first()->id)
            ->update(['empresa_id' => null]);
    }
};
