<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorArea extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'name', 'fee', 'min_delivery_time'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
