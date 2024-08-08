<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'category_id'];
    protected $table = 'category_items';

    // category_itemsテーブルのcategory_idカラムを使用して関連付けを行う。
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // category_itemsテーブルのitem_idカラムを使用して関連付けを行う。
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
