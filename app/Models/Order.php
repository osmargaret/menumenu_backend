<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'kitchen_id', 'subtotal', 'delivery_fee', 'discount', 'total', 'status', 'payment_method', 'address', 'meta',
    ];

    protected $casts = [
        'address' => 'array',
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
