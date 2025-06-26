<?php

namespace App\Filament\Teacher\Resources\TareaResource\Pages;

use App\Filament\Teacher\Resources\TareaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Facades\Filament;

class CreateTarea extends CreateRecord
{
    protected static string $resource = TareaResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $currentMateria = Filament::getTenant();
        $data['materia_id'] = $currentMateria->id;
        return $data;
    }

}
