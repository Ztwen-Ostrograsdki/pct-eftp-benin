<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Book;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = "Les demandes d'achats";

    public static ?string $label = "Demandes d'achats";

    public static function form(Form $form): Form
    {
        
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make("Details de l'achat ou de la commande")->schema([
                        Select::make("user_id")
                              ->label('Client')
                              ->relationship('user', 'pseudo')
                              ->searchable()
                              ->disabledOn('edit')
                              ->preload()
                              ->required(),

                        Select::make('payment_method')
                              ->options(config('app.payments_methods'))
                              ->label('Methode de payement')
                              ->disabledOn('edit')
                              ->required(),

                        Select::make('payment_status')
                              ->options(config('app.payments_status'))
                              ->label('Statut du payement')
                              ->required()
                              ->default('pending'),

                        ToggleButtons::make('status')
                                     ->label("Statut")
                                     ->required()
                                     ->default('new')
                                     ->inline()
                                     ->options(config('app.order_status'))
                                     ->colors([
                                        'new' => "info",
                                        'processing' => "warning",
                                        'shipped' => "success",
                                        'delivered' => "success",
                                        'canceled' => "danger",
                                     ])
                                     ->icons([
                                        'new' => "heroicon-m-sparkles",
                                        'processing' => "heroicon-m-arrow-path",
                                        'shipped' => "heroicon-m-truck",
                                        'delivered' => "heroicon-m-check-badge",
                                        'canceled' => "heroicon-m-x-circle",
                                     ]),
                        Select::make('currency')
                              ->options(config("app.currencies"))
                              ->label('Dévise')
                              ->reactive()
                              ->disabledOn('edit')
                              ->required()
                              ->default('cfa'),

                        Select::make('shipping_method')
                              ->options(config('app.shipping_methods'))
                              ->label('Methode de livraison')
                              ->required()
                              ->disabledOn('edit')
                              ->default('gozem'),

                        Textarea::make('notes')
                                ->columnSpanFull()
                                ->label("Notes (Faculative)")
                                ->placeholder("Des details complémentaires sur la demande...")
                    ])->columns(2),

                    Section::make('Listes des commandes')->schema([
                        Repeater::make('items')
                        ->label('Listes des livres')
                        ->relationship()
                        ->schema([
                            Select::make('book_id')
                                ->label("Le document")
                                ->relationship('book', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->distinct()
                                ->disabledOn('edit')
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->reactive()
                                ->afterStateUpdated(fn ($state, Set $set) => $set('unit_amount', Book::find($state)?->price ?? 0))
                                ->afterStateUpdated(fn ($state, Set $set) => $set('total_amount', Book::find($state)?->price ?? 0))
                                ->columnSpan(4),
                        
                            TextInput::make('quantity')
                                   ->label("La quantité")
                                   ->numeric()
                                   ->required()
                                   ->disabledOn('edit')
                                   ->default(1)
                                   ->minValue(1)
                                   ->reactive()
                                   ->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('total_amount', $state * $get('unit_amount')))
                                   ->columnSpan(2),
                        
                            TextInput::make('unit_amount')
                                    ->label("Prix unitaire")
                                    ->numeric()
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->suffix(fn(Get $get) => isset(config('app.currencies')[$get('currency')]) ? config('app.currencies')[$get('currency')] : config('app.currencies')['cfa'])
                                    ->columnSpan(3),
                            
                            TextInput::make('total_amount')
                                    ->label("Montant total")
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->suffix(fn(Get $get) => isset(config('app.currencies')[$get('currency')]) ? config('app.currencies')[$get('currency')] : config('app.currencies')['cfa'])
                                    ->required()
                                    ->live(onBlur: true)
                                    ->columnSpan(3),
                        ])
                        ->collapsed(false)
                        ->reorderableWithDragAndDrop(true)
                        ->reorderable(true)
                        ->reorderableWithButtons(true)
                        ->addActionLabel("Ajouter des articles")
                        ->columns(12),

                        Placeholder::make('grand_total_placeholder')
                                    ->label('Facturation totale (TTC)')
                                    ->content(function(Get $get, Set $set){
                                        $total = 0;

                                        if(!$repeaters = $get('items')){
                                            return $total;
                                        }

                                        foreach ($repeaters as $key => $repeater){
                                            $total += $get("items.{$key}.total_amount");
                                        }

                                        $curr = $get('currency');

                                        $tax = (float)$get('tax');

                                        $ship = (float)$get('shipping_price');

                                        $reduction = (float)$get('discount') / 100;

                                        $total = ($total - $total * $reduction) + $tax + $ship;

                                        $set('grand_total', $total);

                                        return Number::currency($total, $curr);

                                    }),
                        Hidden::make('grand_total')->default(0),

                    ]),

                    Section::make('Taxe et reduction')->schema([
                        TextInput::make('tax')
                            ->label('La taxe')
                            ->placeholder("Veuillez renseigner la taxe")
                            ->suffix(fn(Get $get) => config('app.currencies')[$get('currency')])
                            ->required()
                            ->live(onBlur: true),

                        TextInput::make('shipping_price')
                            ->label('Taxe de livraison')
                            ->placeholder("Veuillez renseigner la taxe de livraison")
                            ->required()
                            ->suffix(fn(Get $get) => config('app.currencies')[$get('currency')]),
    
                        TextInput::make('discount')
                            ->label("Reduction")
                            ->required()
                            ->live(onBlur: true)
                            ->placeholder("Renseigner la réduction")
                            ->suffix("%"),
                    ])
                    ->columns(3),

                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.pseudo')
                           ->label('Client')
                           ->sortable()
                           ->searchable(),

                TextColumn::make('grand_total')
                           ->numeric()
                           ->label('Coût Total')
                           ->sortable()
                           ->money('CFA')
                           ,

                SelectColumn::make('payment_method')
                           ->searchable()
                           ->disabled()
                           ->options(config('app.payments_methods'))
                           ->label('Methode de payement')
                           ->sortable(),

                SelectColumn::make('payment_status')
                           ->searchable()
                           ->label('Statut du payement')
                           ->sortable()
                           ->options(config('app.payments_status')),

                SelectColumn::make('status')
                           ->label('Statut de la demande')
                           ->options(config('app.order_status')),

                SelectColumn::make('currency')
                           ->label('Devise')
                           ->disabled()
                           ->options(config('app.currencies')),
                
                SelectColumn::make('shipping_method')
                              ->options(config('app.shipping_methods'))
                              ->disabled()
                              ->disabled()
                              ->label('Methode de livraison'),
                
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
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),

                ])
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
