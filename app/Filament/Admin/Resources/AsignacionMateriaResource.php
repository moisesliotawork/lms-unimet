<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AsignacionMateriaResource\Pages;
use App\Filament\Admin\Resources\AsignacionMateriaResource\RelationManagers;
use App\Models\MateriaUser;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use App\Models\Materia;

class AsignacionMateriaResource extends Resource
{
    protected static ?string $model = MateriaUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $modelLabel = 'Asignación de Materias';

    protected static ?string $pluralModelLabel = 'Asignaciones de Materias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Profesor')
                    ->options(User::role('profesor')->pluck('username', 'id'))
                    ->required()
                    ->live(), 
                Forms\Components\Select::make('materia_id')
                    ->label('Materia')
                    ->options(function (Forms\Get $get) {
                        if (!$get('user_id')) {
                            return Materia::pluck('nombre', 'id');
                        }                      
                        return Materia::whereNotIn('id', function($query) use ($get) {
                            $query->select('materia_id')
                                  ->from('materia_user')
                                  ->where('user_id', $get('user_id'))
                                  ->where('role', 'profesor');
                        })->pluck('nombre', 'id');
                    })
                    ->required(),    
                Forms\Components\Hidden::make('role')
                    ->default('profesor')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('profesor.username')
                ->label('Profesor')
                ->sortable()
                ->searchable(),
            
            Tables\Columns\TextColumn::make('materia.nombre')
                ->label('Materia')
                ->sortable()
                ->searchable(),
            
            Tables\Columns\TextColumn::make('role')
                ->label('Rol')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'profesor' => 'primary',
                    default => 'gray',
                }),
            
            Tables\Columns\TextColumn::make('created_at')
                ->label('Asignado el')
                ->dateTime()
                ->sortable(),
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
            'index' => Pages\ListAsignacionMaterias::route('/'),
            'create' => Pages\CreateAsignacionMateria::route('/create'),
            'edit' => Pages\EditAsignacionMateria::route('/{record}/edit'),
        ];
    }
}
