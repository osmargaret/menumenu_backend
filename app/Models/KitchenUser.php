<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KitchenUser extends Model
{
    use HasFactory;

    protected $fillable = ['kitchen_id', 'name', 'email', 'password','role', 'is_active'];

    protected $hidden = [
        'password'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
}
