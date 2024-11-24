<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmpresaResource\Pages;
use App\Filament\Resources\EmpresaResource\RelationManagers;
use App\Models\Empresa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmpresaResource extends Resource
{
    protected static ?string $model = Empresa::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('nombre')
                ->label('Nombre de la Empresa')
                ->required()
                ->maxLength(255),

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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
                Tables\Columns\TextColumn::make('tipo')->label('Tipo'),
                Tables\Columns\TextColumn::make('direccion')->label('Dirección'),
                Tables\Columns\TextColumn::make('telefono')->label('Teléfono'),
                Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label('Actualizado')->dateTime(),
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
            'index' => Pages\ListEmpresas::route('/'),
            'create' => Pages\CreateEmpresa::route('/create'),
            'edit' => Pages\EditEmpresa::route('/{record}/edit'),
        ];
    }
    public static function getNavigationLabel(): string
    {
        return 'Empresas';
    }
}
