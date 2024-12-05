<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiliarResource\Pages;
use App\Filament\Resources\FiliarResource\RelationManagers;
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

class FiliarResource extends Resource
{
    protected static ?string $model = Filiar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = "Les filières";

    public static ?string $label = "Les filières";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Info basiques')->schema([
                    TextInput::make('name')
                        ->label('Nom de la filière')
                        ->placeholder("Veuillez le nom de la filière")
                        ->required()
                        ->unique(Filiar::class, 'name', ignoreRecord: true)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                    TextInput::make('slug')
                        ->label("Identifiant de la filière")
                        ->required()
                        ->disabled()
                        ->dehydrated()
                        ->maxLength(255)
                        ->unique(Filiar::class, 'slug', ignoreRecord: true),
                    

                    Select::make('option')
                                  ->label("L'option de la filière")
                                  ->searchable()
                                  ->preload()
                                  ->options(config('app.filiars_options')),
                ])
                ->columns(3),

                Section::make('Détails sur la filière')->schema([
                    MarkdownEditor::make('description')
                                   ->label("Decrivez la filière")
                                   ->columnSpanFull()
                                   ->fileAttachmentsDirectory('filiars'),
                    

                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label("Filière")->searchable(),
                TextColumn::make('description')->label("Description")->searchable(),
                TextColumn::make('option')->label("Option")->searchable(),
                TextColumn::make('filiar->classes')->label("Classes")->searchable()->default(fn (Model $filiar) => $filiar->classes ? numberZeroFormattor(count($filiar->classes)) : "Aucune classe associée"),

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
            'index' => Pages\ListFiliars::route('/'),
            'create' => Pages\CreateFiliar::route('/create'),
            'edit' => Pages\EditFiliar::route('/{record}/edit'),
        ];
    }
}
