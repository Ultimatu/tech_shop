<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'shipping_fee',
        'payment_method',
        'payment_status',
        'shipping_method',
        'shipping_address_id',
        'billing_address_id',
        'paid_at',
        'canceled_at',
        'shipped_at',
        'delivered_at',
        'total',
        'total_without_fee',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'canceled_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class, 'order_id', 'id', 'id', 'product_id');
    }


    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function billingAddress(){
        return $this->belongsTo(BillingAddress::class);
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function getTotalAttribute($value)
    {
        return number_format($value, 2);
    }

}
