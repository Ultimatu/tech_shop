<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSiteInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'web_site_name',
        'web_site_description',
        'phone_number_1',
        'phone_number_2',
        'email_1',
        'email_2',
        'working_hours',
        'address',
        'city',
        'facebook',
        'whatsapp',
        'instagram',
        'shoppify',
        'image_logo',
        'image_favicon',
        'is_active'
    ];

    public function getImageLogoAttribute($value)
    {
        return asset('storage/' . $value);
    }

    public function getImageFaviconAttribute($value)
    {
        return asset('storage/' . $value);
    }

    
    protected function casts()
    {
        return [
            'is_active' => 'boolean'
        ];
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true)->first();
    }
}
