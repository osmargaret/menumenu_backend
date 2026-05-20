<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenUser extends Model
{
    use HasFactory;

    protected $fillable = ['kitchen_id', 'user_id', 'role', 'status'];

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
