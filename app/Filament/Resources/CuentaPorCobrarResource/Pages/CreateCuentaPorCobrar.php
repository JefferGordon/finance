<?php

namespace App\Filament\Resources\CuentaPorCobrarResource\Pages;

use App\Filament\Resources\CuentaPorCobrarResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCuentaPorCobrar extends CreateRecord
{
    protected static string $resource = CuentaPorCobrarResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['es_recurrente'] ?? false) {
            $montoPorLetra = $data['monto'] / $data['cantidad_meses'];
            $fecha = \Carbon\Carbon::parse($data['fecha_vencimiento']);

            $letras = [];
            for ($i = 0; $i < $data['cantidad_meses']; $i++) {
                $letras[] = [
                    'monto' => $montoPorLetra,
                    'fecha_vencimiento' => $fecha->copy()->addMonths($i),
                    'estado' => 'pendiente',
                ];
            }

            $data['letras'] = $letras;
        }

       

        return $data;
    }

    
    protected function afterCreate(): void
    {
        $record = $this->record; // Accede al registro recién creado
    
        if ($record->es_recurrente && $record->cantidad_meses) {
            $montoPorLetra = $record->monto / $record->cantidad_meses;
            $fecha = \Carbon\Carbon::parse($record->fecha_vencimiento);
    
            for ($i = 0; $i < $record->cantidad_meses; $i++) {
                $record->letras()->create([
                    'monto' => $montoPorLetra,
                    'fecha_vencimiento' => $fecha->copy()->addMonths($i),
                    'estado' => 'pendiente',
                ]);
            }
        }
    }
    
        
        
        
}
