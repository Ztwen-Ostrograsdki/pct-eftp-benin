<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

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
    use HasFactory, Notifiable, UserTrait;

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
        'state',
        'born_at',
        'teaching_since',
        'marital_status',
        'graduate',
        'graduate_type',
        'graduate_year',
        'graduate_delivery',
        'grade',
        'years_experiences',
        'contacts',
        'birth_city',
        'matricule',
        'is_ame',
        'status',
        'ability',
        'confirmed_by_admin'
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

}
