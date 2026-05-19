<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KitchenLogistics extends Model
{
    use HasFactory;

    protected $fillable = ['kitchen_id', 'name', 'fee', 'min_delivery_time'];

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
}
