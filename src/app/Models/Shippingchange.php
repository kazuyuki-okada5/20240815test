<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'post_code',
        'address',
        'building',
    ];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function item()
    {
        return $this->belongsTo(item::class);
    }

        public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
