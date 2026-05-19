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

    public function kitchens()
    {
        return $this->belongsToMany(Kitchen::class, 'category_kitchen');
    }
}
