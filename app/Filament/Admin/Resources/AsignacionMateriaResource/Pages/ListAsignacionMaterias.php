<?php

namespace App\Filament\Admin\Resources\AsignacionMateriaResource\Pages;

use App\Filament\Admin\Resources\AsignacionMateriaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsignacionMaterias extends ListRecords
{
    protected static string $resource = AsignacionMateriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
