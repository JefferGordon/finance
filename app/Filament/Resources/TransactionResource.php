<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;


class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('empresa_id')
                ->label('Empresa')
                ->relationship('empresa', 'nombre')
                ->preload()
                ->searchable()
                ->createOptionForm([
                    Forms\Components\TextInput::make('nombre')
                        ->label('Nombre de la Empresa')
                        ->required(),

                    Forms\Components\Select::make('tipo')
                        ->label('Tipo de Empresa')
                        ->options([
                            'natural' => 'Natural',
                            'juridica' => 'Jurídica',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('direccion')
                        ->label('Dirección')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('telefono')
                        ->label('Teléfono')
                        ->maxLength(15),
                ]),
            TextInput::make('year')
                ->label('Año')
                ->default(date('Y')) // Prellena con el año actual
                ->required()
                ->numeric(),
            Select::make('month_id')
                ->label('Mes')
                ->relationship('month', 'name') // Relación con el modelo `Months`
                ->preload() // Precarga las opciones
                ->searchable() // Permite buscar los meses
                ->required(), // Campo obligatorio
            Select::make('transaction_type_id')
                ->relationship('transactionType', 'name')
                ->label('Tipo de Transacción')
                ->required(),
            
            TextInput::make('amount')
                ->label('Monto')
                ->numeric()
                ->required(),
            
            Textarea::make('description')
                ->label('Descripción'),

            DatePicker::make('transaction_date')
                ->label('Fecha de Transacción')
                ->required()
                ->beforeOrEqual(now()) // Valida que no sea una fecha futura
                ->displayFormat('d/m/Y') // Formato de visualización
                ->format('Y-m-d') // Formato de almacenamiento
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
             
                Tables\Columns\TextColumn::make('empresa.nombre')->label('Empresa'), // Relación con Empresa
                Tables\Columns\TextColumn::make('transactionType.name')->label('Tipo'),
                Tables\Columns\TextColumn::make('amount')->label('Monto'),
                Tables\Columns\TextColumn::make('transaction_date')->label('Fecha de Transacción')->date(),
                Tables\Columns\TextColumn::make('year') ->label('Año'),
                Tables\Columns\TextColumn::make('month.name')->label('Mes'),
           
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('empresa_id')
                ->label('Empresa')
                ->relationship('empresa', 'nombre'),
                SelectFilter::make('year')
                ->label('Año')
                ->options(self::getAvailableYears()) // Obtener opciones dinámicas de años
                ->default(date('Y')), 
                Tables\Filters\SelectFilter::make('month_id')
                ->label('Mes')
                ->relationship('month', 'name') // 
                ->placeholder('Selecciona un Mes'), // 
            ])
            ->searchable()
            ->defaultSort('transaction_date', 'desc')
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
    public static function getNavigationLabel(): string
    {
        return 'Transacciones';
    }

    protected static function rules(): array
    {
        return [
            'transaction_date' => 'required|date|before_or_equal:today',
        ];
    }
    protected static function getAvailableYears(): array
    {
        return Transaction::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year', 'year') // Devuelve un array donde clave = valor
            ->toArray();
    }
}
