<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Teléfono
        $data['phone_prefix'] = substr($data['phone'], 0, 4);
        $data['phone_suffix'] = substr($data['phone'], 4);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['phone'] = $data['phone_prefix'] . $data['phone_suffix'];

        // Elimina los campos auxiliares para evitar errores si no están en fillable
        unset($data['phone_prefix'], $data['phone_suffix']);

        return $data;
    }
}
