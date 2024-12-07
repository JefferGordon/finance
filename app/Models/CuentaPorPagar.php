<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPorPagar extends Model
{
    use HasFactory;
    protected $fillable = ['empresa_id', 'detalle', 'monto', 'fecha_vencimiento','estado','es_recurrente','cantidad_meses'];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    protected static function booted()
    {
        static::creating(function ($cuenta) {
            if ($cuenta->es_recurrente) {
                $fechaBase = \Carbon\Carbon::parse($cuenta->fecha_vencimiento);

                for ($i = 1; $i < $cuenta->cantidad_meses; $i++) {
                    static::create([
                        'empresa_id' => $cuenta->empresa_id,
                        'detalle' => $cuenta->detalle,
                        'monto' => $cuenta->monto,
                        'fecha_vencimiento' => $fechaBase->copy()->addMonths($i),
                        'estado' => $cuenta->estado,
                        'es_recurrente' => false, // Solo la primera es recurrente, las demás no
                    ]);
                }
            }
        });
        static::updating(function ($cuenta) {
            if ($cuenta->isDirty('estado') && $cuenta->estado === 'pagado') {
                Transaction::create([
                    'empresa_id' => $cuenta->empresa_id,
                    'transaction_type_id' => 2, // 2 = egreso
                    'amount' => $cuenta->monto,
                    'description' => "Pago de cuenta por pagar: {$cuenta->detalle}",
                    'transaction_date' => now(),
                    'month_id' => now()->month,
                    'year' => now()->year,
                ]);
            }
        });
    }

    

}
