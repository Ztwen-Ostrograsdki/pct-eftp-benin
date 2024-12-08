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
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

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

                    Section::make('Info basiques et Dénomination')->schema([
                        TextInput::make('name')
                            ->label('Nom du livre')
                            ->placeholder("Veuillez le nom du livre")
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' || $operation === 'edit' ? $set('slug', Str::slug($state)) : null)
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('identifiant', Str::random(16)) : null)
                            ->required(),
                        
                        TextInput::make('slug')
                            ->label("Identifiant du livre/document")
                            ->placeholder("Identifiant du livre/Document")
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->maxLength(255)
                            ->unique(Book::class, 'slug', ignoreRecord: true),


                        TextInput::make('identifiant')
                            ->label("Identifiant numerique du livre/document")
                            ->placeholder("Identifiant numérique du livre/Document")
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->maxLength(255)
                            ->unique(Book::class, 'identifiant', ignoreRecord: true),

                    ])
                    ->columns(3),

                    Section::make('Identification et Prix')->schema([

                        TextInput::make('price')
                                  ->label('Le prix')
                                  ->required()
                                  ->prefix('FCFA'),
                        
                        TextInput::make('quantity_bought')
                                  ->label("Quantités disponibles")
                                  ->required()
                                  ->suffix('exemplaires'),
                        
                        Select::make('user_id')
                                  ->label("Publieur du livre ou document")
                                  ->required()
                                  ->searchable()
                                  ->preload()
                                  ->relationship('user', 'pseudo'),

                    ])
                    ->columns(3),

                    Section::make('Edition')->schema([
                        

                        TextInput::make('last_edited_year')
                                ->label('Dernière édition faite en ')
                                ->placeholder("Dernière édition du livre/document faite en "),

                        TextInput::make('edited_home')
                                ->label("Maison d'édition du livre")
                                ->placeholder("Veuillez préciser la maison d'édition du livre")
                                ->default("Maison d'édition du livre")
                                ->required(),

                    ])->columns(2),

                    Section::make('Détails pédagogiques')->schema([
                        
                        Select::make('promotion_id')
                                  ->label('Un document de la promotion ')
                                  ->searchable()
                                  ->default(null)
                                  ->placeholder("Veuillez préciser la promotion concernée")
                                  ->preload()
                                  ->relationship('promotion', 'name'),
                        
                        
                        Select::make('classes_id')
                                  ->label('Un document des classes de')
                                  ->searchable()
                                  ->default(null)
                                  ->multiple()
                                  ->preload()
                                  ->options(getClasses(true, 'by name')),

                        Select::make('filiars_id')
                                  ->label('Les filières concernées')
                                  ->searchable()
                                  ->multiple()
                                  ->default(null)
                                  ->preload()
                                  ->options(getFiliars(true, 'by name')),

                    ])->columns(3),

                    Section::make('Détails sur le livre ou le document')->schema([
                        MarkdownEditor::make('description')
                                       ->label("Decrivez le document ou le livre")
                                       ->columnSpanFull()
                                       ->fileAttachmentsDirectory('books'),
                        

                    ])->columns(1),

                    Section::make('Statuts du document ou du livre')->schema([
                        
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
                                   ->maxFiles(10)

                    ]),

                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label("Livre ou Document")->searchable(),
                
                TextColumn::make('description')->label("Description")->searchable(),

                TextColumn::make('user.email')->label("Publié par ")->searchable()->description(fn(Model $book) => $book->user ? $book->user->getFullName() : 'inconnu' ),
                
                TextColumn::make('quantity_bought')->label("Qtité disponibles")->searchable()->description(fn(Model $book) => $book->quantity_bought ? numberZeroFormattor($book->quantity_bought) . ' livres disponibles ' : 'Non renseigné' ),
                
                TextColumn::make('edited_home')->label("Edité par")->searchable(),
                
                TextColumn::make('last_edited_year')->label("Edité en ")->searchable(),
                
                TextColumn::make('price')->label("Le prix")->money("CFA", 0, 'fr')->sortable(),
                
                IconColumn::make('on_sale')->label("En vente ?")->boolean(),

                IconColumn::make('is_active')->label("Est actif ?")->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->label("Date de Création")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->label("Date de MAJ")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
