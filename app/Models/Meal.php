<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'kitchen_id', 'name', 'slug', 'description', 'price', 'currency', 'available', 'prep_time', 'category', 'image_path',
    ];

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
