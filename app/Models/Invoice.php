<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_id',
        'invoice_date',
        'invoice_number',
        'status',
        'payment_method',
        'payment_date',
        'payment_proof',
        'due_date',
        'note',
    ];
}
