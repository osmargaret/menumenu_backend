<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenVerification extends Model
{
    use HasFactory;

    protected $fillable = ['kitchen_id','status','reviewed_by','notes','reviewed_at'];

    protected $casts = ['reviewed_at' => 'datetime'];

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
