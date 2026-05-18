<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'icon', 'popularity', 'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'category_vendor');
    }
}
