<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'title', 'slug', 'excerpt', 'body', 'cover_path', 'views', 'is_published', 'published_at',
    ];

    protected $dates = ['published_at'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
