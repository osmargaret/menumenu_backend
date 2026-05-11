<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'type', 'value', 'vendor_id', 'uses', 'max_uses', 'expires_at',
    ];

    protected $dates = ['expires_at'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
