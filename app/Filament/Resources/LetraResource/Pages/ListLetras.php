<?php

namespace App\Filament\Resources\LetraResource\Pages;

use App\Filament\Resources\LetraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLetras extends ListRecords
{
    protected static string $resource = LetraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
