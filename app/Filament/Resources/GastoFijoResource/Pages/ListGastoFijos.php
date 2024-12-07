<?php

namespace App\Filament\Resources\GastoFijoResource\Pages;

use App\Filament\Resources\GastoFijoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGastoFijos extends ListRecords
{
    protected static string $resource = GastoFijoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
