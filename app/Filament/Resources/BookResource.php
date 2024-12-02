<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationLabel = "Les Livres";

    public static ?string $label = "La librairie des livres";

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Info basiques')->schema([
                        TextInput::make('name')
                            ->label('Nom du livre')
                            ->placeholder("Veuillez le nom du livre")
                            ->default("le nom du livre")
                            ->required(),

                        TextInput::make('title')
                                ->label('Titre du livre')
                                ->placeholder("Veuillez renseigner le titre du livre")
                                ->default("le titre du livre")
                                ->required(),

                        TextInput::make('price')
                                  ->label('Le prix')
                                  ->required()
                                  ->prefix('FCFA'),
                        
                        TextInput::make('quantity_bought')
                                  ->label("Quantités disponibles")
                                  ->required()
                                  ->suffix('exemplaires')

                    ])
                    ->columns(5),

                    Section::make('Edition')->schema([
                        TextInput::make('Edition')
                                ->label('Edition ')
                                ->placeholder("Veuillez renseigner le du livre")
                                ->default("l'édition du livre")
                                ->required(),

                        DatePicker::make('edited_at')
                                ->label('Edtité vérifié le ')
                                ->default(now()),

                        TextInput::make('edited_home')
                                ->label("Maison d'édition du livre")
                                ->placeholder("Veuillez préciser la maison d'édition du livre")
                                ->default("Maison d'édition du livre")
                                ->required(),

                    ])->columns(4),

                    Section::make('Détails pédagogiques')->schema([
                        
                        Select::make('user_id')
                                  ->label("Publieur du livre ou document")
                                  ->required()
                                  ->searchable()
                                  ->preload()
                                  ->relationship('user', 'pseudo'),
                        
                        Select::make('classe_id')
                                  ->label('La classe')
                                  ->required()
                                  ->searchable()
                                  ->preload()
                                  ->relationship('classe', 'name'),
                        
                        
                        

                    ])->columns(5),


                    Section::make('Détails sur le livre ou le document')->schema([
                        MarkdownEditor::make('description')
                                       ->label("Decrivez le document ou le livre")
                                       ->columnSpanFull()
                                       ->fileAttachmentsDirectory('products'),
                        

                    ])->columns(1),

                    Section::make('Statuts du document ou du livre')->schema([
                        
                        Toggle::make('in_stock')
                                ->label('Est disponible ?')
                                ->required()
                                ->default(true),

                        Toggle::make('is_active')
                                ->label('Est actif ?')
                                ->required()
                                ->default(true),
                        
                        Toggle::make('hidden')
                                ->label('Masqué ?')
                                ->required()
                                ->default(true),

                        Toggle::make('authorized')
                                ->label('Autorisé ?')
                                ->required()
                                ->default(true),
                        
                        Toggle::make('on_sale')
                                ->label('En vente ?')
                                ->required()

                    ])->columns(5),

                    Section::make('Images Associées')->schema([
                        FileUpload::make('images')
                                   ->label('Les images associées')
                                   ->multiple()
                                   ->required()
                                   ->directory('books')
                                   ->reorderable()
                                   ->maxFiles(5)

                    ]),

                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
