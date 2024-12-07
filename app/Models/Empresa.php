<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'tipo', 'direccion', 'telefono'];
    public function transactions()
    {
    return $this->hasMany(Transaction::class);
    }
    public function cuentasPorPagar()
    {
        return $this->hasMany(CuentaPorPagar::class);
    }
    public function cuentasPorCobrar()
    {
        return $this->hasMany(CuentaPorCobrar::class, 'empresa_id');
    }
    public function GastoFijo()
    {
        return $this->hasMany(GastoFijo::class, 'empresa_id');
    }
    
}
