<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'order_id',
        'payment_date',
        'payment_method',
        'status',
        'amount',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getPaymentDateAttribute($value)
    {
        return $value ? $value : $this->created_at;
    }

    public function getAmountAttribute($value)
    {
        return $value ? $value : $this->order->total;
    }
}
