<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'second_name',
        "second_last_name",
        "phone",
        "address"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    protected $appends = ['phone_prefix', 'phone_number'];


    public function getNameAttribute()
    {
        return $this->username;
    }

    public function getPhonePrefixAttribute(): ?string
    {
        return $this->phone ? substr($this->phone, 0, 4) : null;
    }

    public function getPhoneNumberAttribute(): ?string
    {
        return $this->phone ? substr($this->phone, 4) : null;
    }

    public function setPhonePrefixAttribute(?string $value): void
    {
        // Este método es solo para el formulario, no guarda nada
    }

    public function setPhoneNumberAttribute(?string $value): void
    {
        if ($value && $this->phone_prefix) {
            $this->attributes['phone'] = $this->phone_prefix . $value;
        }
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $panelId = $panel->getId();

        if($panelId === 'admin'){
            return $this->hasRole('admin');
        }
        
        if($panelId === 'profesor'){
            return $this->hasRole('profesor');
        }

        if($panelId === 'user'){
            return $this->hasRole('estudiante');
        }

        return false;
    }
}
