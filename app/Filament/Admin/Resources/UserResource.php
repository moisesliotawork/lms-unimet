<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use App\Enums\PhonePrefix;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Usuario';

    protected static ?string $pluralModelLabel = 'Usuarios';

    protected static ?string $navigationGroup = 'Administración';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('username')
                    ->label("Username")
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('email')
                    ->label("Correo")
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),


                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label("Nueva Contraseña")
                            ->password()
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->required(fn(string $operation): bool => $operation === 'create'),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label("Confirmar Contraseña")
                            ->password()
                            ->same('password')
                            ->maxLength(255)
                            ->dehydrated(false)
                            ->required(fn(string $operation): bool => $operation === 'create'),
                    ])
                    ->columns(2)
                    ->visibleOn(['create', 'edit']),

                Forms\Components\TextInput::make('first_name')
                    ->label(label: "Primer Nombre")
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('second_name')
                    ->label("Segundo Nombre")
                    ->maxLength(255),

                Forms\Components\TextInput::make('last_name')
                    ->label("Primer Apellido")
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('second_last_name')
                    ->label("Segundo Apellido")
                    ->maxLength(255),

                Select::make('phone_prefix')
                    ->label('Prefijo Teléfono')
                    ->options(PhonePrefix::options())
                    ->required(),

                TextInput::make('phone_suffix')
                    ->label('Número Teléfono')
                    ->numeric()
                    ->minLength(7)
                    ->maxLength(7)
                    ->required(),

                Forms\Components\Textarea::make('address')
                    ->label("Direccion")
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('second_name')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('second_last_name')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('phone')
                    ->formatStateUsing(fn($state) => $state ? substr($state, 0, 4) . ' ' . substr($state, 4) : '')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
