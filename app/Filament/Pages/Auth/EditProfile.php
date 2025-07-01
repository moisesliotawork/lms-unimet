<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class EditProfile extends BaseEditProfile
{
    /**
     * Configura el esquema del formulario de edición de perfil.
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->default(fn() => Auth::user()->first_name),

                TextInput::make('second_name')
                    ->label('Segundo Nombre')
                    ->maxLength(255)
                    ->default(fn() => Auth::user()->second_name),

                TextInput::make('last_name')
                    ->label('Apellido')
                    ->required()
                    ->maxLength(255)
                    ->default(fn() => Auth::user()->last_name),

                TextInput::make('second_last_name')
                    ->label('Segundo Apellido')
                    ->maxLength(255)
                    ->default(fn() => Auth::user()->second_last_name),

                TextInput::make('username')
                    ->label('Nombre de Usuario')
                    ->required()
                    ->maxLength(255)
                    ->default(fn() => Auth::user()->username),

                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true) // Cambiado esta línea
                    ->default(fn() => Auth::user()->email),

                TextInput::make('address')
                    ->label('Direccion')
                    ->maxLength(255)
                    ->default(fn() => Auth::user()->address),

                TextInput::make('phone')
                    ->label('Número de Teléfono')
                    ->tel()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true) // Cambiado esta línea
                    ->default(fn() => Auth::user()->phone),

                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    /**
     * Sobrescribe el método para manejar la lógica de guardar los datos del perfil.
     */
    public function save(): void
    {
        $data = $this->form->getState();

        $user = Auth::user();
        $user->fill($data);
        $user->save();
        parent::save();
    }
}