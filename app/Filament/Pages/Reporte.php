<?php
namespace App\Filament\Pages;

use App\Models\Transaction;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class Reporte extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $title = 'Reporte de Transacciones';
    protected static string $view = 'filament.pages.reporte';

    public $empresaId = null;
    public $monthId = null;

    public $ingresos = 0;
    public $egresos = 0;
    public $saldo = 0;

    public $fechaInicio = null;
    public $fechaFin = null;


    public function mount(Request $request): void
    {
        $this->empresaId = $request->input('empresa_id');
        $this->monthId = $request->input('month_id');
        $this->fechaInicio = $request->input('fecha_inicio');
        $this->fechaFin = $request->input('fecha_fin');

        $this->calculateFilteredData();
    }

    public function calculateFilteredData()
    {
        $this->ingresos = Transaction::where('transaction_type_id', 1)
            ->when($this->empresaId, fn($query) => $query->where('empresa_id', $this->empresaId))
            ->when(request('fecha_inicio') && request('fecha_fin'), fn($query) => $query->whereBetween('transaction_date', [request('fecha_inicio'), request('fecha_fin')]))
            ->sum('amount');
    
        $this->egresos = Transaction::where('transaction_type_id', 2)
            ->when($this->empresaId, fn($query) => $query->where('empresa_id', $this->empresaId))
            ->when(request('fecha_inicio') && request('fecha_fin'), fn($query) => $query->whereBetween('transaction_date', [request('fecha_inicio'), request('fecha_fin')]))
            ->sum('amount');
    
        $this->saldo = $this->ingresos - $this->egresos;
    }
}
