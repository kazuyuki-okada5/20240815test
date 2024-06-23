<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'item_id', 'shipping_change_id', 'payment_id' ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
