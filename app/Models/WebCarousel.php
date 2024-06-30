<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebCarousel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image'
    ];


    public function getImageAttribute($value)
    {
        return asset('storage/' . $value);
    }

}
