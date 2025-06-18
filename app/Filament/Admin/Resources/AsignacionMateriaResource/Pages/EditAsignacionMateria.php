<?php

namespace App\Filament\Admin\Resources\AsignacionMateriaResource\Pages;

use App\Filament\Admin\Resources\AsignacionMateriaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsignacionMateria extends EditRecord
{
    protected static string $resource = AsignacionMateriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
{
    $data['materia_id'] = $this->record->profesor // Accede al profesor
        ->materias() // Ahora sí existe esta relación
        ->wherePivot('role', 'profesor')
        ->pluck('materia_id')
        ->toArray();
        
    return $data;
}
}
