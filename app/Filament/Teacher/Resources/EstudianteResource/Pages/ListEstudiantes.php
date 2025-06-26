<?php

namespace App\Filament\Teacher\Resources\EstudianteResource\Pages;

use App\Filament\Teacher\Resources\EstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEstudiantes extends ListRecords
{
    protected static string $resource = EstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
