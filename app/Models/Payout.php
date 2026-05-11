<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id','amount','fee','status','method','meta','paid_at'];

    protected $casts = ['meta' => 'array', 'paid_at' => 'datetime'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
