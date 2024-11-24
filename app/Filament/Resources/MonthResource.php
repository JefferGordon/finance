<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonthResource\Pages;
use App\Filament\Resources\MonthResource\RelationManagers;
use App\Models\Month;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonthResource extends Resource
{
    protected static ?string $model = Month::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('name')->label('Nombre'),
                Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label('Actualizado')->dateTime(),
            ])
            ->filters([]);
            
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
            'index' => Pages\ListMonths::route('/'),
            
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function getNavigationLabel(): string
    {
        return 'Meses';
    }
    
}
