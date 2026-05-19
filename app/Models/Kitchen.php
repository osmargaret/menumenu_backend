<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Kitchen extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'user_id', 'name', 'slug', 'email', 'phone', 'password', 'tagline', 'description',
        'banner_path', 'avatar_path', 'address', 'state_id', 'city_id', 'is_open', 'open_time', 'close_time',
        'delivery_available', 'pickup_available', 'commission_percent',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        //
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function scopeInState($query, $stateId)
    {
        if (! $stateId) {
            return $query;
        }
        return $query->where('state_id', $stateId);
    }

    public function areas()
    {
        return $this->hasMany(KitchenLogistics::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'category_kitchen');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function team()
    {
        return $this->hasMany(KitchenUser::class);
    }

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }
}
