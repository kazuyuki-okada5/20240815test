<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Like;

class UserController extends Controller
{
    public function show($id)
    {
        $user = user::findOFail($id);
        return view('items.detail', compact('user'));
    }

    public function mypage()
    {
        $items = Item::all(); // すべてのアイテム
        $likes = collect(); // 空のコレクションをデフォルトとする

        if (Auth::check()) {
            $user = Auth::user();
            $likes = Like::where('user_id', $user->id)->get(); // ユーザーのお気に入り
            return view('auth.mypage', compact('user', 'items', 'likes'));
        } else {
            return view('auth.mypage', compact('items', 'likes'));
        }
    }

    
}
