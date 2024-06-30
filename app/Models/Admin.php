<?php

namespace App\Models;

use Filament\Actions\Concerns\CanNotify;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel\Concerns\HasDatabaseTransactions;
use Filament\Panel\Concerns\HasNotifications;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, HasNotifications, CanNotify, HasDatabaseTransactions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'email_verified_at',
        'address',
        'phone_number',
        'city'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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


    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return auth('admin')->check();
    }

    public function getFilamentAvatarUrl(): string|null
    {
        return $this->image_avatar ? url($this->image_avatar) : asset('assets/images/default-user.png');
    }

    public function getProfilePictureUrlAttribute(): string|null
    {
        return $this->profile_picture ? ( str_contains($this->profile_picture, 'assets') || str_contains($this->profile_picture, 'storage') ? url($this->profile_picture) : asset('storage/' . $this->profile_picture)) : asset('assets/images/default-user.png');
    }

    public function setProfilePictureAttribute($value): void
    {
        $this->attributes['profile_picture'] = $value ? (str_contains($value, 'assets') ? $value : 'storage/' . $value) : null;
    }
}
