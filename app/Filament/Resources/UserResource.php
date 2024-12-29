<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Attributes\Title;

#[Title("Les utilisateurs  - {{config('app.name')}}")]
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = "Les utilisateurs";

    public static ?string $label = "Les Utilisateurs";

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Info basiques')->schema([
                        TextInput::make('pseudo')
                            ->label('Nom utilisateur ou pseudo')
                            ->placeholder("Veuillez entrer votre Pseudo")
                            ->default("Votre pseudo")
                            ->required(),

                        TextInput::make('email')
                                ->label('Adress mail')
                                ->email()
                                ->maxlength('255')
                                ->disabledOn('edit')
                                ->unique(ignoreRecord: true)
                                ->required(),
                        
                        DateTimePicker::make('email_verified_at')
                                ->label('Email vérifié le ')
                                ->default(now()),

                        TextInput::make('password')
                                ->label('mot de passe')
                                ->password()
                                ->hiddenOn('edit')
                                ->dehydrated(fn($state) => filled($state))
                                ->required(fn(Page $livewire) : bool => $livewire instanceof CreateRecord)
                    ])
                    ->columns(3),

                    Section::make('Info Personnelles')->schema([
                        TextInput::make('firstname')
                            ->label('Nom')
                            ->required()
                            ->disabledOn('edit')
                            ->placeholder("Votre nom"),

                        TextInput::make('lastname')
                                ->label('Prénoms')
                                ->disabledOn('edit')
                                ->required()
                                ->placeholder("Vos prénoms"),
                        
                        DatePicker::make('birth_date')
                                ->label('Date de naissance')
                                ->default(now())
                                ->placeholder("Votre date de naissance"),

                        TextInput::make('birth_city')
                                ->label('Né à')
                                ->placeholder("Votre ville et pays de naissance"),

                    ])->columns(4),

                    Section::make('Civilités')->schema([
                        TextInput::make('marital_status')
                            ->label('Statut matrimonial')
                            ->required()
                            ->placeholder("Statut matrimonial"),

                        TextInput::make('contacts')
                                ->label('Contacts')
                                ->required()
                                ->placeholder("66876565 / 61564377 / ..."),
                        

                        TextInput::make('address')
                                ->label('Adresse')
                                ->placeholder("Précisez l'adresse: Commune - Ville - Quatier"),

                        Select::make('gender')
                                ->label("Sexe")
                                ->required()
                                ->options([
                                    'male' => "Masculin",
                                    'female' => "Féminin",
                                    'other' => "Autre",
                                ]),
                        

                    ])->columns(4),

                    Section::make('Diplômes')->schema([
                        TextInput::make('graduate')
                            ->label('Diplome élevé')
                            ->required()
                            ->placeholder("Le diplôme le plus élevé"),

                        Select::make('graduate_type')
                                ->required()
                                ->options([
                                    'academique' => "Académique",
                                    'professionnel' => "Professionnel",
                                    'autre' => "Autre",
                                ])
                                ->label('Type de diplôme'),
                        
                        TextInput::make('graduate_year')
                                ->label('Année')
                                ->required()
                                ->placeholder("L'année d'obtention du diplôme"),

                        TextInput::make('graduate_deliver')
                                ->label('Autorité')
                                ->required()
                                ->placeholder("Instance ayant délivrée le diplôme"),

                    ])->columns(4),

                    Section::make('Profession et expériences dans le métier 1')->schema([
                        
                        TextInput::make('job_city')
                            ->label('Ville de travail')
                            ->required()
                            ->placeholder("La ville de travail"),

                        TextInput::make('school')
                                ->label('Ecole ou établissement')
                                ->placeholder("L'écolde ou établissement de travail"),
                        
                        DatePicker::make('teaching_since')
                                ->label('Enseigne dépuis')
                                ->default(now())
                                ->placeholder("Précisez la date de première prise de fonction"),

                        TextInput::make('years_experiences')
                                ->label('Expériences')
                                ->required()
                                ->placeholder("Années d'expérience"),

                    ])->columns(4),

                    Section::make('Profession et expériences dans le métier 2')->schema([
                        
                        TextInput::make('grade')
                                ->label('Grade')
                                ->required()
                                ->placeholder("Votre grade"),
                        
                        TextInput::make('matricule')
                                ->label('Matricule')
                                ->disabledOn('edit')
                                ->required()
                                ->placeholder("Votre matricule"),
                                
                        Select::make('status')
                                ->options([
                                    'ame' => 'AME',
                                    'fnae' => 'FNAE',
                                    'ape' => 'APE',
                                    'acdpe' => 'ACDPE',
                                    'other' => 'Autre',
                                ])
                                ->placeholder("Votre statut")
                                ->label('Statut')
                                ->required()
                                ->searchable(),

                    ])->columns(3),

                    Section::make('Photo de Profil')->schema([
                        FileUpload::make('profil_photo')
                        ->image()
                        ->disabledOn('edit')
                        ->directory('users'),
                    ]),

                ])->columnSpanFull()
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profil_photo')->label("Photo")->circular(true),
                TextColumn::make('firstname')->label("Nom")->searchable()->default(fn (Model $user) => $user->firstname ? $user->firstname : "non renseigné"),
                TextColumn::make('lastname')->label("Prénoms")->searchable()->default(fn (Model $user) => $user->lastname ? $user->lastname : "non renseigné"),
                TextColumn::make('address')->label("Adresse")->searchable()->default(fn (Model $user) => $user->address ? $user->address : "non renseigné"),
                TextColumn::make('birth_date')->date()->label("Né le")->searchable(),
                TextColumn::make('status')->label("Statut")->searchable()->default(fn (Model $user) => $user->status ? $user->status : "non renseigné"),
                TextColumn::make('email')->searchable(),
                TextColumn::make('grade')->label("Grade")->searchable()->default(fn (Model $user) => $user->grade ? $user->grade : "non renseigné"),
                TextColumn::make('matricule')->label("Matricule")->searchable()->default(fn (Model $user) => $user->matricule ? $user->matricule : "non renseigné"),
                TextColumn::make('school')->label("Etablissement")->searchable()->default(fn (Model $user) => $user->school ? $user->school : "non renseigné"),
                TextColumn::make('job_city')->label("Déployé à ")->searchable()->default(fn (Model $user) => $user->job_city ? $user->job_city : "non renseigné"),
                TextColumn::make('years_experiences')->label("Expériences")->searchable()->default(fn (Model $user) => $user->years_experiences ? $user->years_experiences : "non renseigné"),
                TextColumn::make('graduate')->label("Diplôme")->searchable()->description('Le diplome')->default(fn (Model $user) => $user->graduate ? $user->graduate : "non renseigné"),
                TextColumn::make('graduate_deliver')->label("Délivré par")->searchable()->description('Le diplome')->default(fn (Model $user) => $user->graduate_delivery ? $user->graduate_delivery : "non renseigné"),
                TextColumn::make('graduate_type')->sortable()->label("Type de diplôme")->toggleable(isToggledHiddenByDefault: true)->default(fn (Model $user) => $user->graduate_type ? $user->graduate_type : "non renseigné"),
                TextColumn::make('teaching_since')->dateTime()->sortable()->label("Enseigne dépuis le")->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email_verified_at')->dateTime()->sortable()->label("Vérifié le")->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('contacts')->sortable()->label("Contacts")->toggleable(isToggledHiddenByDefault: true)->default(fn (Model $user) => $user->contacts ? $user->contacts : "non renseigné"),
                TextColumn::make('birth_city')->sortable()->label("Né à ")->toggleable(isToggledHiddenByDefault: true)->default(fn (Model $user) => $user->born_city ? $user->born_city : "non renseigné"),
                TextColumn::make('marital_status')->sortable()->label("Status matrimonial")->toggleable(isToggledHiddenByDefault: true)->default(fn (Model $user) => $user->marital_status ? $user->marital_status : "non renseigné"),
                TextColumn::make('created_at')->dateTime()->sortable()->label("Inscrit le")->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->label("Mis à jour le")->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ability')->sortable()->label("Abilités ou rôle")->toggleable(isToggledHiddenByDefault: true)->default(fn (Model $user) => $user->ability ? $user->ability : "non renseigné"),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),

                    Action::make('sendEmail')
                            ->label("Envoyer un mail ")
                            ->color('info')
                            ->icon('heroicon-o-rectangle-stack')
                            ->form([
                                TextInput::make('email')
                                            ->label("Receveur")
                                            ->default(fn (Model $user) => $user->email ?$user->email : "non renseigné")
                                            ->dehydrated()
                                            ->disabled()
                                            ->required(),
                                TextInput::make('subject')->required(),
                                RichEditor::make('body')->required(),
                            ])
                            ->action(function (Model $user, array $data) {

                                
                            }),

                    Action::make('markAsVerified')
                            ->label("Action sur la vérification du mail")
                            ->color(fn (Model $user) => $user->emailVerified() ? "danger" : "success")
                            ->icon( fn (Model $user) => $user->emailVerified() ? "heroicon-o-lock-closed" : "heroicon-o-lock-open")
                            ->form([
                                Checkbox::make('as_verified')
                                        ->label('Marquer: compte déjà Verifié')
                                        ->reactive()
                                        ->default(function(User $user){
                                            return  $user->emailVerified();
                                        })
                                        ->afterStateUpdated(fn ($state, Set $set) => $set('as_not_verified', $state == true ? false : true)),
                                Checkbox::make('as_not_verified')
                                        ->label('Marquer: Compte Non Verifié')
                                        ->reactive()
                                        ->default(function(User $user){
                                            return  !$user->emailVerified();
                                        })
                                        ->afterStateUpdated(fn ($state, Set $set) => $set('as_verified', $state == true ? false : true)),
                                
                            ])
                            ->action(function (Model $user, array $data) {

                                $user->markUserAsVerifiedOrNot($data['as_verified'], $data['as_not_verified']);
                                
                            })

                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('markLotAsNotVerified')
                            ->label("Marquer le comptes non vérifiés")
                            ->color('danger')
                            ->icon("heroicon-o-lock-closed")
                            ->form([
                                Checkbox::make('as_not_verified')
                                        ->label('Marquer les utilisateurs sélectionés : Compte Non Verifié')
                                        ->default(true)
                            ])
                            ->action(function (Collection $users, array $data) {

                                $users->each->markUserAsVerifiedOrNot(false, true);
                                
                            })->deselectRecordsAfterCompletion(),

                        BulkAction::make('markLotAsVerified')
                            ->label("Marquer le comptes vérifiés")
                            ->color('success')
                            ->icon("heroicon-o-lock-open")
                            ->form([
                                Checkbox::make('as_verified')
                                        ->label('Marquer les utilisateurs sélectionés : Compte Verifié')
                                        ->default(true)
                            ])
                            ->action(function (Collection $users, array $data) {

                                $users->each->markUserAsVerifiedOrNot(true, false);
                                
                            })->deselectRecordsAfterCompletion(),
                    
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
