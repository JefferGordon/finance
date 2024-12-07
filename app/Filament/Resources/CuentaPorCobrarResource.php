<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CuentaPorCobrarResource\Pages;
use App\Filament\Resources\CuentaPorCobrarResource\RelationManagers;
use App\Models\CuentaPorCobrar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class CuentaPorCobrarResource extends Resource
{
    protected static ?string $model = CuentaPorCobrar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


      

        

    public static function form(Form $form): Form
    {
        
        return $form
        ->schema([
            Select::make('empresa_id')
                ->label('Empresa')
                ->relationship('empresa', 'nombre')
                ->required(),
        
            TextInput::make('detalle')
                ->label('Detalle')
                ->required()
                ->maxLength(255),
        
            TextInput::make('monto')
                ->label('Monto')
                ->required()
                ->numeric(),
        
            DatePicker::make('fecha_vencimiento')
                ->label('Fecha de Vencimiento')
                ->required()
                ->minDate(now()),
        
            Select::make('estado')
                ->label('Estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'cobrado' => 'Cobrado',
                ])
                ->default('pendiente'),
        
            // Campos para recurrencia
            Forms\Components\Toggle::make('es_recurrente')
                ->label('Es Recurrente')
                ->reactive(),
            TextInput::make('cantidad_meses')
                ->label('Cantidad de Meses')
                ->numeric()
                ->minValue(1)
                ->maxValue(60)
                ->visible(fn ($get) => $get('es_recurrente')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('empresa.nombre')->label('Empresa'),
                TextColumn::make('detalle')->label('Detalle'),
                TextColumn::make('monto')->label('Monto')->money('usd'),
                TextColumn::make('fecha_vencimiento')->label('Fecha de Vencimiento')->date(),
                TextColumn::make('saldoRestante')->label('Saldo Restante')
                ->money('usd')
                ->getStateUsing(function ($record) {
                    return $record->saldoRestante();
                }),
                TextColumn::make('estado')->label('Estado'),
                Tables\Columns\ToggleColumn::make('es_recurrente')->label('Recurrente')->disabled(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'cobrado' => 'Cobrado',
                    ])
                    ->label('Estado'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('registrarAbono')
                    ->label('Registrar Abono')
                    ->icon('heroicon-o-currency-dollar')
                    ->form([
                        TextInput::make('monto')
                            ->label('Monto Abonado')
                            ->required()
                            ->numeric()
                            ->maxValue(fn ($record) => $record->saldoRestante()),
                        DatePicker::make('fecha_abono')
                            ->label('Fecha del Abono')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->abonos()->create([
                            'monto' => $data['monto'],
                            'fecha_abono' => $data['fecha_abono'],
                        ]);
    
                        $record->marcarComoPagada(); // Verifica y cambia el estado si está completamente pagada
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([ Tables\Actions\DeleteBulkAction::make(),]);
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\LetrasRelationManager::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCuentaPorCobrars::route('/'),
            'create' => Pages\CreateCuentaPorCobrar::route('/create'),
            'edit' => Pages\EditCuentaPorCobrar::route('/{record}/edit'),
        ];
    }


}
