<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClasseResource\Pages;
use App\Filament\Resources\ClasseResource\RelationManagers;
use App\Models\Classe;
use App\Models\Filiar;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ClasseResource extends Resource
{
    protected static ?string $model = Classe::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = "Les classes";

    public static ?string $label = "Les classes";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Info basiques')->schema([
                    TextInput::make('name')
                        ->label('Nom de la classe')
                        ->placeholder("Veuillez le nom de la classe")
                        ->unique(Classe::class, 'name', ignoreRecord: true)
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' || $operation === 'edit' ? $set('slug', Str::slug($state)) : null),

                    TextInput::make('slug')
                        ->label("Identifiant de la classe")
                        ->required()
                        ->disabled()
                        ->placeholder("Identifiant de la classe")
                        ->dehydrated()
                        ->maxLength(255)
                        ->unique(Classe::class, 'slug', ignoreRecord: true),
                ])
                ->columns(2),

                Section::make('Promotion et Filière')->schema([

                    Select::make('promotion_id')
                                  ->label('La Promotion')
                                  ->required()
                                  ->searchable()
                                  ->preload()
                                  ->relationship('promotion', 'name'),

                    Select::make('filiar_id')
                                  ->label('La Filière')
                                  ->required()
                                  ->searchable()
                                  ->preload()
                                  ->relationship('filiar', 'name'),

                ])
                ->columns(2),

                Section::make('Détails sur la classe')->schema([
                    MarkdownEditor::make('description')
                                   ->label("Decrivez la classe")
                                   ->columnSpanFull()
                                   ->fileAttachmentsDirectory('classes'),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label("Classe")->searchable(),
                TextColumn::make('description')->label("Description")->searchable(),
                TextColumn::make('filiar->promotion')->label("Promotion")->searchable()->default(fn (Model $classe) => $classe->promotion ? $classe->promotion->name : "Aucune Promotion associée"),
                TextColumn::make('filiar->name')->label("Filière")->searchable()->default(fn (Model $classe) => $classe->filiar ? $classe->filiar->name : "Aucune filière associée"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClasse::route('/create'),
            'edit' => Pages\EditClasse::route('/{record}/edit'),
        ];
    }
}
