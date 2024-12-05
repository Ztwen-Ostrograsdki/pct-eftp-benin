<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionResource\Pages;
use App\Filament\Resources\PromotionResource\RelationManagers;
use App\Models\Promotion;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
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

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = "Les promotions";

    public static ?string $label = "Les promotions";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Info basiques')->schema([
                    TextInput::make('name')
                        ->label('Nom de la promotion')
                        ->placeholder("Veuillez le nom de la promotion")
                        ->required()
                        ->unique(Promotion::class, 'name', ignoreRecord: true)->unique()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                    TextInput::make('slug')
                        ->label("Identifiant de la promotion")
                        ->placeholder("L'identifiant de la promotion")
                        ->required()
                        ->disabled()
                        ->dehydrated()
                        ->maxLength(255)
                        ->unique(Promotion::class, 'slug', ignoreRecord: true),
                ])
                ->columns(2),

                Section::make('Détails sur la promotion')->schema([
                    MarkdownEditor::make('description')
                                   ->label("Decrivez la promotion")
                                   ->columnSpanFull()
                                   ->fileAttachmentsDirectory('promotions'),

                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label("Filière")->searchable(),
                TextColumn::make('description')->label("Description")->searchable(),
                TextColumn::make('promotion->classes')->label("Classes")->searchable()->default(fn (Model $promotion) => $promotion->classes ? numberZeroFormattor(count($promotion->classes)) : "Aucune classe associée"),

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
            'index' => Pages\ListPromotions::route('/'),
            'create' => Pages\CreatePromotion::route('/create'),
            'edit' => Pages\EditPromotion::route('/{record}/edit'),
        ];
    }
}
