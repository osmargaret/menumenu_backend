<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationCenter extends Model
{
    use HasFactory;

    protected $table = 'notifications_center';

    protected $fillable = [
        'user_id', 'type', 'title', 'body', 'data', 'is_read',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
