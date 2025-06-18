<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MateriaResource\Pages;
use App\Filament\Admin\Resources\MateriaResource\RelationManagers;
use App\Models\Materia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MateriaResource extends Resource
{
    protected static ?string $model = Materia::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                ->label("Nombre")
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('descripcion')
                ->label("Descripcion")
                    ->columnSpanFull(),
                Forms\Components\Select::make('departamento_id')
                ->label("Departamento")
                    ->relationship('departamento', 'name')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('URL amigable')
                    ->unique(table: 'materias', column: 'slug', ignoreRecord: false)
                    ->maxLength(255)
                    ->hint('Dejar en blanco para generar automáticamente')
                    ->rules(['alpha_dash:ascii']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                ->label("Nombre")
                    ->searchable(),
                Tables\Columns\TextColumn::make('departamento.name')
                ->label("Departamento")
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                ->label("Fecha de Creación")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label("Fecha de Actualización")
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
            'index' => Pages\ListMaterias::route('/'),
            'create' => Pages\CreateMateria::route('/create'),
            'edit' => Pages\EditMateria::route('/{record}/edit'),
        ];
    }
}
