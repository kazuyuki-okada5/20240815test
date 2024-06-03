<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
        //　大量代入の際に保護される属性リストを指定する
    protected $guarded = ['id'];
        //　バリデーションルールを適用
    public static $rules = [
        'user_id' => 'required',
        'condition_id' => 'required',
        'name' => 'required|max:255',
        'price' => 'required|integer',
        'comment' => 'required',
        'image_url' => 'required|max:255',
        'brand' => 'nullable|max:255',
        'sold_user_id' => 'nullable',
    ];
        //　Itemsテーブルのuser_idカラムを使用しUsersテーブルのレコードを参照
    public function user()
    {
        return $this->belongsTo(User::class);
    }

        //　Itemsテーブルのcondition_idカラムを使用しConditionsテーブルのレコードを参照
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

        //　アイテムが購入された時、購入者のidを取得
    public function soldUser()
    {
        return $this->belongsTo(User::class, 'sold_user_id');
    }

        //　Likesテーブルにidカラムを取得させItemsテーブルのレコードを参照させる
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

        //　Commentsテーブルにidカラムを取得させItemsテーブルのレコードを参照させる
    public function Comments()
    {
        return $this->hasMany(Comment::class);
    }

        //　Category_Itemsテーブルにidカラムを取得させItemsテーブルのレコードを参照させる
    public function Categories()
    {
        return $this->belongsToMany(Item::class, 'category_items');
    }
}