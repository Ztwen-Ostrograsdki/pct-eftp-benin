<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\Dater\DateFormattor;
use App\Helpers\TraitsManagers\UserTrait;
use App\Observers\ObserveUser;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[ObservedBy(ObserveUser::class)]
class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, UserTrait, DateFormattor;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudo',
        'email',
        'password',
        'profil_photo',
        'lastname',
        'firstname',
        'gender',
        'job_city',
        'school',
        'address',
        'teaching_since',
        'marital_status',
        'graduate',
        'graduate_type',
        'graduate_year',
        'graduate_deliver',
        'grade',
        'years_experiences',
        'contacts',
        'birth_city',
        'birth_date',
        'matricule',
        'is_ame',
        'status',
        'ability',
        'current_function',
        'email_verified_at',
    ];

    protected $admins_attr = [
        'confirmed_by_admin',
        'blocked',
        'blocked_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'password_reset_key',
        'email_verify_key'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function classes()
    {

    }


    public function epreuves()
    {
        
    }

    public function getFilamentName(): string
    {
        return $this->pseudo;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->id === 1 ;
    }

    public function getFilamentAvatarUrl() : ?string
    {
        return asset($this->profil_photo);
    }

    public function getGender($gender = null)
    {
        if(!$gender) $gender = $this->gender;

        $genders = [
            'female' => "Féminin",
            'Féminin' => "Féminin",
            'Female' => "Féminin",
            'male' => "Masculin",
            'Masculin' => "Masculin",
            'Male' => "Masculin",
            'other' => "Autre",
            'Autre' => "Autre",
            null => "Non renseigné",
        ];

        return $genders[$gender];
    }


    public function getUserNamePrefix()
    {
        if(in_array($this->gender, ['male', 'Male', 'M', 'm', 'masculin', 'Masculin'])) return 'Mr';

        if(in_array($this->gender, ['female', 'Female', 'F', 'f', 'feminin', 'Féminin', 'Feminin'])) return 'Mme';

        return 'Mr/Mme';
    }

}
