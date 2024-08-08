<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // 大量代入で許可される属性リストを指定。
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // シリアライズ時に隠す属性リストを指定。
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // 型変換を行う属性リストを指定。
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // items` テーブルのレコードを取得。
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // Profilesテーブルのレコードを取得。
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // likesテーブルのレコードを取得。
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // likesテーブルを介してitemsテーブルのレコードを取得。
    public function likedItems()
    {
        return $this->belongsToMany(Item::class, 'likes');
    }

    // commentsテーブルのレコードを取得。
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}