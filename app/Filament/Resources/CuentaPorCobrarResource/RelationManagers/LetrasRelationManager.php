<?php

namespace App\Filament\Resources\CuentaPorCobrarResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables; // Esta es la clase correcta para tablas
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
class LetrasRelationManager extends RelationManager
{
    protected static string $relationship = 'letras'; // Define la relación con el modelo principal.

    public function table(Tables\Table $table): Tables\Table // Cambiar a Filament\Tables\Table
    {
        return $table
        ->columns([
            TextColumn::make('monto')
                ->label('Monto')
                ->money('usd'),
            TextColumn::make('fecha_vencimiento')
                ->label('Fecha de Vencimiento')
                ->date(),
            TextColumn::make('estado')
                ->label('Estado'),
        ])
        ->actions([
            Action::make('pagar')
                ->label('Registrar Pago')
                ->icon('heroicon-o-credit-card')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->marcarComoPagado();

                    // Registrar la transacción como ingreso
                    \App\Models\Transaction::create([
                        'empresa_id' => $record->cuentaPorCobrar->empresa_id,
                        'transaction_type_id' => 1, // ID de tipo "Ingreso"
                        'amount' => $record->monto,
                        'description' => 'Pago de letra',
                        'month_id' => now()->month,
                        'year' => now()->year,
                    ]);
                })
                ->visible(fn ($record) => $record->estado === 'pendiente'),
        ]);
    }
}
