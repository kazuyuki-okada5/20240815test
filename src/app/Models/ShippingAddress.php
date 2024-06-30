<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'post_code',
        'address',
        'building',
    ];

    public function item()
    {
        return $this->belongsTo(item::class);
    }

        public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
