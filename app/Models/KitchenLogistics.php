<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenLogistics extends Model
{
    use HasFactory;

    protected $fillable = ['kitchen_id', 'city_id', 'town', 'fee', 'min_delivery_time'];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->town;
    }

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
}
