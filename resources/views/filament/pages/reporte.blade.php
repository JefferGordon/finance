<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <x-filament::page>
        
    <div>
        <h1 class="text-xl font-bold">Reporte de Transacciones</h1>
    
        <!-- Filtros -->
        <form method="GET" class="flex space-x-4">
            <select name="empresa_id" class="form-control">
                <option value="">Seleccione una Empresa</option>
                @foreach (\App\Models\Empresa::all() as $empresa)
                    <option value="{{ $empresa->id }}" {{ request('empresa_id') == $empresa->id ? 'selected' : '' }}>
                        {{ $empresa->nombre }}
                    </option>
                @endforeach
            </select>
            <select name="year" class="form-control">
                <option value="">Seleccione un Año</option>
                @for ($i = date('Y'); $i >= 2000; $i--)
                    <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
            <select name="month_id" class="form-control">
                <option value="">Seleccione un Mes</option>
                @foreach (\App\Models\Month::all() as $month)
                    <option value="{{ $month->id }}" {{ request('month_id') == $month->id ? 'selected' : '' }}>
                        {{ $month->name }}
                    </option>
                @endforeach
            </select>
    
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filtrar</button>
        </form>
    
        <!-- Resultados -->
        <div class="mt-6 grid grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-bold">Ingresos vs Egresos</h2>
                <canvas id="chart"></canvas>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-lg font-bold">Saldo</h2>
                <p class="text-2xl font-semibold text-green-600">${{ number_format($saldo, 2) }}</p>
            </div>
        </div>
    </div>
    
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Ingresos', 'Egresos'],
                datasets: [{
                    label: 'Monto',
                    data: [{{ $ingresos }}, {{ $egresos }}],
                    backgroundColor: ['#28a745', '#dc3545'], // Colores para ingresos y egresos
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    
    </x-filament::page>
    