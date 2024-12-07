<?php

namespace App\Filament\Resources\LetraResource\Pages;

use App\Filament\Resources\LetraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLetra extends EditRecord
{
    protected static string $resource = LetraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
