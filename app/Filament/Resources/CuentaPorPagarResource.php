<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CuentaPorPagarResource\Pages;
use App\Filament\Resources\CuentaPorPagarResource\RelationManagers;
use App\Models\CuentaPorPagar;
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
use Filament\Forms\Components\Toggle;

class CuentaPorPagarResource extends Resource
{
    protected static ?string $model = CuentaPorPagar::class;

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
            Toggle::make('es_recurrente')
                ->label('¿Es Recurrente?')
                ->default(false),

            TextInput::make('cantidad_meses')
                ->label('Cantidad de Meses')
                ->numeric()
                ->minValue(1)
                ->maxValue(60) // Limitar a un máximo razonable
                ->visible(fn ($get) => $get('es_recurrente')),
        
            Select::make('estado')
                ->label('Estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'pagado' => 'Pagado',
                ])
                ->default('pendiente'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('empresa.nombre')
                ->label('Empresa')
                ->sortable()
                ->searchable(),
                
                TextColumn::make('detalle')
                    ->label('Detalle'),
                    
                TextColumn::make('monto')
                    ->label('Monto')
                    ->money('usd'), // Formato de moneda
            
                TextColumn::make('fecha_vencimiento')
                    ->label('Fecha de Vencimiento')
                    ->date(),
            
                TextColumn::make('estado')
                    ->label('Estado')
                    ->formatStateUsing(fn (string $state): string => [
                        'pendiente' => 'Pendiente',
                        'pagado' => 'Pagado',
                        'cobrado' => 'Cobrado',
                    ][$state] ?? 'Desconocido')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCuentaPorPagars::route('/'),
            'create' => Pages\CreateCuentaPorPagar::route('/create'),
            'edit' => Pages\EditCuentaPorPagar::route('/{record}/edit'),
        ];
    }
}
