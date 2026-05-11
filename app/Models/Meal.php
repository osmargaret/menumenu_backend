<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'name', 'slug', 'description', 'price', 'currency', 'available', 'prep_time', 'category', 'image_path',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
