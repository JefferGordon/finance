<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoFijo extends Model
{
    use HasFactory;
    protected $fillable = [
        'empresa_id',
        'detalle',
        'monto',
        'estado',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    protected static function booted()
    {
        static::updating(function ($gasto) {
            if ($gasto->isDirty('estado') && $gasto->estado === 'pagado') {
                Transaction::create([
                    'empresa_id' => $gasto->empresa_id,
                    'transaction_type_id' => 2, // 2 = egreso
                    'amount' => $gasto->monto,
                    'description' => "Pago de gasto fijo: {$gasto->detalle}",
                    'fecha_transaccion' => now(),
                ]);
            }
        });
    }
}
