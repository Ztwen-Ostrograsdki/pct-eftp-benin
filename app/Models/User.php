<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\Dater\DateFormattor;
use App\Helpers\TraitsManagers\UserTrait;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'confirmed_by_admin',
        'email_verified_at'
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
            'male' => "Masculin",
            'other' => "Autre",
            null => "Non renseigné",
        ];

        return $genders[$gender];
    }

}
