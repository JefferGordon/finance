<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letra extends Model
{
    use HasFactory;
    protected $fillable = [
        'cuenta_por_cobrar_id',
        'monto',
        'fecha_vencimiento',
        'estado',
    ];

    public function cuentaPorCobrar()
    {
        return $this->belongsTo(CuentaPorCobrar::class, 'cuenta_por_cobrar_id');
    }
    public function marcarComoPagado()
    {
        $this->estado = 'pagado';
        $this->save();
    }
}
