<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['phone'] = $data['phone_prefix'] . $data['phone_suffix'];

        // Elimina los campos auxiliares para evitar errores si no están en fillable
        unset($data['phone_prefix'], $data['phone_suffix']);

        return $data;
    }
}
