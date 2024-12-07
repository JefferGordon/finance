<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPorCobrar extends Model
{
    use HasFactory;
    protected $fillable = ['empresa_id', 'detalle', 'monto', 'fecha_vencimiento','estado','cantidad_meses','es_recurrente'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function letras()
    {
        return $this->hasMany(Letra::class, 'cuenta_por_cobrar_id');
    }
    public function abonos()
    {
        return $this->hasMany(Abono::class, 'cuenta_por_cobrar_id');
    }
    protected static function booted()
    {
        static::updating(function ($cuenta) {
            if ($cuenta->isDirty('estado') && $cuenta->estado === 'cobrado') {
                Transaction::create([
                    'empresa_id' => $cuenta->empresa_id,
                    'transaction_type_id' => 1, // 1 = ingreso
                    'amount' => $cuenta->monto,
                    'description' => "Ingreso de cuenta por cobrar: {$cuenta->detalle}",
                    'transaction_date' => now(),
                    'month_id' => now()->month,
                    'year' => now()->year,
                ]);
            }
        });
    }
    public function saldoRestante()
    {
        $totalAbonos = $this->abonos()->sum('monto');
        return $this->monto - $totalAbonos;
    }

    public function marcarComoPagada()
    {
        if ($this->saldoRestante() <= 0) {
            $this->update(['estado' => 'pagado']);
        }
    }
    public function actualizarEstado()
    {
        if ($this->saldoRestante() <= 0) {
            $this->update(['estado' => 'cobrado']); // Marca como cobrada si el saldo restante es cero
        }
    }
    }
