<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSiteSponsor extends Model
{
    use HasFactory;



    protected $fillable = [
        'name',
        'image',
        'url',
        'is_active',
        'priority'
    ];
}
