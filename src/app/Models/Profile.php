<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
        //　マスアサインメント（編集）可能な属性を定義する
    protected $fillable = ['user_id', 'img_url', 'post_code', 'address', 'building',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profileImage()
    {
        // プロフィール画像の URL を返す
        return $this->img_url ? asset('storage/' . $this->img_url) : null;
    }
}