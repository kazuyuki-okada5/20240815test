<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'item_id', 'comment'];

    // commentsテーブルのuser_idカラムを使用して関連付けを行う。
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // commentsテーブルのitem_idカラムを使用して関連付けを行う。
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
