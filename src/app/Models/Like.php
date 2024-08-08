<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'item_id'];

    // likesテーブルのuser_idカラムを使用して、usersテーブルのレコードを参照。
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // likesテーブルのitem_idカラムを使用して、itemsテーブルのレコードを参照。
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
