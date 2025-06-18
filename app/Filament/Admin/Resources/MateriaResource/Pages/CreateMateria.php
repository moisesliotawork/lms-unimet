<?php

namespace App\Filament\Admin\Resources\MateriaResource\Pages;

use App\Filament\Admin\Resources\MateriaResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateMateria extends CreateRecord
{
    protected static string $resource = MateriaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generar slug si no se proporcionó
        $data['slug'] = $this->generateUniqueSlug($data['slug'] ?? Str::slug($data['nombre']));

        return $data;
    }

    protected function generateUniqueSlug(string $slug): string
    {
        $originalSlug = $slug;
        $count = 1;

        while ($this->getModel()::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    protected function onValidationError(ValidationException $exception): void
    {
        $errors = $exception->validator->errors();

        if ($errors->has('slug')) {
            Notification::make()
                ->title('Error en el slug')
                ->body('El slug debe ser único. Intente con otro valor o déjelo en blanco para generar uno automáticamente.')
                ->danger()
                ->send();
        }

        parent::onValidationError($exception);
    }
}