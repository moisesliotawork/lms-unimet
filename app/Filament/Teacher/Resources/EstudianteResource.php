<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\EstudianteResource\Pages;
use App\Filament\Teacher\Resources\EstudianteResource\RelationManagers;
use App\Models\User;
use App\Models\Materia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

class EstudianteResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Estudiantes';

    protected static ?string $modelLabel = 'Estudiante';

    protected static bool $isScopedToTenant = false;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->role('estudiante');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('materia_actual')
                    ->label('Mostrar solo esta materia')
                    ->query(fn(Builder $query) => $query->whereHas('materias', function ($q) {
                        $q->where('materias.id', filament()->getTenant()?->id);
                    }))
                    ->default()
                    ->indicator('Solo estudiantes de esta materia'),
            ])
            ->actions([
                Tables\Actions\Action::make('asignar_materia')
                    ->label('Asignar Materia')
                    ->icon('heroicon-o-academic-cap')
                    ->form([
                        Forms\Components\Select::make('materia_id')
                            ->label('Materia')
                            ->options(function () {
                                return Materia::whereHas('profesores', function ($query) {
                                    $query->where('users.id', auth()->id());
                                })
                                    ->get()
                                    ->pluck('nombre', 'id');
                            })
                            ->default(filament()->getTenant()?->id)
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (User $record, array $data): void {
                        if ($record->materias()->where('materias.id', $data['materia_id'])->exists()) {
                            Notification::make()
                                ->title('Error')
                                ->body('Este estudiante ya tiene asignada esta materia.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->materias()->attach($data['materia_id'], ['role' => 'estudiante']);

                        Notification::make()
                            ->title('Asignación exitosa')
                            ->body("El estudiante {$record->name} fue asignado a la materia correctamente.")
                            ->success()
                            ->send();
                    })
                    ->visible(fn() => !is_null(filament()->getTenant()))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Opcional: Acción masiva para asignar materia a varios estudiantes
                    Tables\Actions\BulkAction::make('asignarMateria')
                        ->icon('heroicon-o-academic-cap')
                        ->form([
                            Forms\Components\Select::make('materia_id')
                                ->label('Materia')
                                ->options(function () {
                                    return Materia::whereHas('profesores', function ($query) {
                                        $query->where('users.id', auth()->id());
                                    })
                                        ->get()
                                        ->pluck('nombre', 'id');
                                })
                                ->default(filament()->getTenant()?->id)
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                if (!$record->materias()->where('materias.id', $data['materia_id'])->exists()) {
                                    $record->materias()->attach($data['materia_id'], ['role' => 'estudiante']);
                                }
                            }
                        }),
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
            'index' => Pages\ListEstudiantes::route('/'),
            'create' => Pages\CreateEstudiante::route('/create'),
            'edit' => Pages\EditEstudiante::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
}
