<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GastoFijoResource\Pages;
use App\Filament\Resources\GastoFijoResource\RelationManagers;
use App\Models\GastoFijo;
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
class GastoFijoResource extends Resource
{
    protected static ?string $model = GastoFijo::class;

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
                    ->required(),
            
                TextInput::make('monto')
                    ->label('Monto')
                    ->numeric()
                    ->required(),
            
                DatePicker::make('fecha_inicio')
                    ->label('Fecha de Inicio')
                    ->required(),
            
                Toggle::make('es_gasto_fijo')
                    ->label('¿Es Gasto Fijo?')
                    ->default(false), // Por defecto no es un gasto fijo
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListGastoFijos::route('/'),
            'create' => Pages\CreateGastoFijo::route('/create'),
            'edit' => Pages\EditGastoFijo::route('/{record}/edit'),
        ];
    }
}
