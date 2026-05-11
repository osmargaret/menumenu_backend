<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorVerification extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id','status','reviewed_by','notes','reviewed_at'];

    protected $casts = ['reviewed_at' => 'datetime'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
