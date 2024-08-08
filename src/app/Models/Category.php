<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // category_itemsテーブルを中間テーブルとして使用しcategory_idおよびitem_idカラムで関連付けを行う。
    public function items()
    {
        return $this->belongsToMany(Item::class, 'category_items', 'category_id', 'item_id');
    }
}
