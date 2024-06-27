<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'name',
        'slug',
        'description',
        'image_primary',
        'price_with_discount',
        'price_without_discount',
        'stock',
        'is_featured',
        'is_active',
        'is_in_stock',
        'is_promoted',
        'view_count',
        'promotion_percent',
        'promotion_start',
        'promotion_end',
        'tags',
    ];

    protected function casts(): array
    {
        return [
            'promotion_start' => 'datetime',
            'promotion_end' => 'datetime',
            'price_with_discount' => 'decimal:2',
            'price_without_discount' => 'decimal:2',
            'stock' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'is_in_stock' => 'boolean',
            'is_promoted' => 'boolean',
            'tags' => 'array',
        ];
    }
    

    public function category()
    {
        return $this->belongsToThrough(Category::class, SubCategory::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function items()
    {
        return $this->hasMany(ProductItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getDiscountPercentAttribute()
    {
        return $this->price_without_discount ? round((($this->price_without_discount - $this->price_with_discount) / $this->price_without_discount) * 100) : 0;
    }

    public function getDiscountAmountAttribute()
    {
        return $this->price_without_discount ? $this->price_without_discount - $this->price_with_discount : 0;
    }

    public function getRatingAttribute()
    {
        return $this->reviews->avg('rating');
    }

    public function getRatingCountAttribute()
    {
        return $this->reviews->count();
    }

    public function getRatingPercentAttribute()
    {
        return $this->rating ? round(($this->rating / 5) * 100) : 0;
    }

    public function getRatingCountPercentAttribute()
    {
        return $this->rating_count ? round(($this->rating_count / 100) * 100) : 0;
    }

    public function getRatingCountPercentRoundedAttribute()
    {
        return $this->rating_count_percent ? round($this->rating_count_percent) : 0;
    }

}
