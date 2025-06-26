<?php

namespace App\Filament\Teacher\Resources\TareaResource\Pages;

use App\Filament\Teacher\Resources\TareaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTareas extends ListRecords
{
    protected static string $resource = TareaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
