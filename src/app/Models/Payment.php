<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // 大量代入で許可される属性リストを指定。
    protected $fillable = [
        'item_id', 'amount', 'method', 'status',
    ];

    // paymentsテーブルのitem_idカラムを使用して、itemsテーブルのレコードを参照。
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}