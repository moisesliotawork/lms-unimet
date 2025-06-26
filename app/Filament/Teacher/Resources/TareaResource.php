<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\TareaResource\Pages;
use App\Filament\Teacher\Resources\TareaResource\RelationManagers;
use App\Models\Tarea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;

class TareaResource extends Resource
{
    protected static ?string $model = Tarea::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $tenantOwnershipRelationshipName = 'materia';

    protected static ?string $modelLabel = 'Tarea';

    protected static ?string $pluralModelLabel = 'Tareas';

    protected static ?string $navigationLabel = 'Tareas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('documento')
                    ->directory('tareas-documentos')
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
                    Forms\Components\Textarea::make('observaciones')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('fecha_inicio')
                    ->label('Fecha de Inicio')
                    ->required(),

                Forms\Components\DatePicker::make('fecha_cierre')
                    ->label('Fecha de Cierre')
                    ->required(),
            ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('observaciones')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->dateTime()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('fecha_cierre')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('documento')
                    ->searchable(),
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
            'index' => Pages\ListTareas::route('/'),
            'create' => Pages\CreateTarea::route('/create'),
            'edit' => Pages\EditTarea::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        $currentMateria = Filament::getTenant();
        
        return parent::getEloquentQuery()
            ->where('materia_id', $currentMateria->id);
    }
}
