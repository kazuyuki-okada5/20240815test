<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    // conditionsテーブルのidカラムを使用して関連付けを行いアイテムに対する状態を取得。
    public function item()
    {
        return $this->hasOne(Item::class);
    }
}
