<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'profile_picture',
        'email_verified_at',
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

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function getProfilePictureUrlAttribute(): string|null
    {
        return $this->profile_picture ? ( str_contains($this->profile_picture, 'assets') || str_contains($this->profile_picture, 'storage') ? url($this->profile_picture) : asset('storage/' . $this->profile_picture)) : asset('assets/images/default-user.png');
    }

    public function setProfilePictureAttribute($value): void
    {
        $this->attributes['profile_picture'] = $value ? (str_contains($value, 'assets') ? $value : 'storage/' . $value) : null;
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function cartItems()
    {
        return $this->hasManyThrough(CartItem::class, Cart::class);
    }

    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }

    public function defaultShippingAddress()
    {
        return $this->hasOne(ShippingAddress::class)->where('is_default', true);
    }
   
}
