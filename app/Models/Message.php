<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'is_read',
        'is_answered',
        'answer'
    ];

    protected function casts()
    {
        return [
            'is_read' => 'boolean',
            'is_answered' => 'boolean'
        ];
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
