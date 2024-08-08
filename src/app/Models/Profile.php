<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // 大量代入で許可される属性リストを指定。
    protected $fillable = ['user_id', 'img_url', 'post_code', 'address', 'building',];

    // profilesテーブルのuser_idカラムを使用して、usersテーブルのレコードを参照。
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
