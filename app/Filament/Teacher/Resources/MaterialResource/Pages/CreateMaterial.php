<?php

namespace App\Filament\Teacher\Resources\MaterialResource\Pages;

use App\Filament\Teacher\Resources\MaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Facades\Filament;

class CreateMaterial extends CreateRecord
{
    protected static string $resource = MaterialResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $currentMateria = Filament::getTenant();
        $data['materia_id'] = $currentMateria->id;
        return $data;
    }
}