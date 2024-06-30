<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'is_active',
        'priority',
        'slug'
    ];

    protected function casts()
    {
        return [
            'is_active' => 'boolean',
            'priority' => 'integer'
        ];
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeNormal($query)
    {
        return $query->priority(0);
    }

    public function scopeHigh($query)
    {
        return $query->priority(1);
    }

    public function scopeOrderByPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }


}
