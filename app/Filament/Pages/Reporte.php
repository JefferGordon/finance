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

    public function mount(Request $request): void
    {
        $this->empresaId = $request->input('empresa_id');
        $this->monthId = $request->input('month_id');

        $this->calculateFilteredData();
    }

    public function calculateFilteredData()
    {
        // Consulta separada para ingresos
        $this->ingresos = Transaction::where('transaction_type_id', 1)
            ->when($this->empresaId, fn($query) => $query->where('empresa_id', $this->empresaId))
            ->when($this->monthId, fn($query) => $query->where('month_id', $this->monthId))
            ->when(request('year'), fn($query) => $query->where('year', request('year')))
            ->sum('amount');

        // Consulta separada para egresos
        $this->egresos = Transaction::where('transaction_type_id', 2)
            ->when($this->empresaId, fn($query) => $query->where('empresa_id', $this->empresaId))
            ->when($this->monthId, fn($query) => $query->where('month_id', $this->monthId))
            ->when(request('year'), fn($query) => $query->where('year', request('year')))
            ->sum('amount');

        // Calcular saldo
        $this->saldo = $this->ingresos - $this->egresos;
    }
}
