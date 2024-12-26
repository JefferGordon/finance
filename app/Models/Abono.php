<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;
    protected $fillable = [
        'monto',
        'fecha_abono',
        'cuenta_por_cobrar_id', 
    ];
    public function cuentaPorCobrar()
    {
        return $this->belongsTo(CuentaPorCobrar::class, 'cuenta_por_cobrar_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($abono) {
            // Registrar la transacción
            \App\Models\Transaction::create([
                'empresa_id' => $abono->cuentaPorCobrar->empresa_id, // Obtiene la empresa asociada a la cuenta por cobrar
                'transaction_type_id' => 1, // Tipo de transacción (ingreso)
                'transaction_date' => $abono->fecha_abono, // Fecha del abono
                'amount' => $abono->monto, // Monto del abono
                'description' => "Abono registrado para la cuenta por cobrar #{$abono->cuenta_por_cobrar_id}",
                'month_id' => date('n', strtotime($abono->fecha_abono)), // Mes del abono
                'year' => date('Y', strtotime($abono->fecha_abono)), // Año del abono
            ]);
        });
    }

}
