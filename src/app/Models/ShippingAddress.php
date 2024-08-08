<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    // 大量代入で許可される属性リストを指定。
    protected $fillable = [
        'item_id',
        'post_code',
        'address',
        'building',
    ];

    // shipping_addressesテーブルのitem_idカラムを使用して、itemsテーブルのレコードを参照。
    public function item()
    {
        return $this->belongsTo(item::class);
    }

    // shipping_addressesテーブルのレコードに関連する複数のpaymentsテーブルのレコードを取得。
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
