<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // お気に入り追加
    public function like($itemId)
    {
        $userId = Auth::id();
        if(!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインが必要です。');
        }
        $existingLike = Like::where('user_id', $userId)
            ->where('item_id', $itemId)
            ->first();
        if (!$existingLike) {
            $like = new Like([
                'user_id' => $userId,
                'item_id' => $itemId,
            ]);
            $like->save();

            return redirect()->back()->with('success', 'お気に入りに追加しました');
        }
    }

    // お気に入り削除
    public function unlike($itemId)
    {
        $userId = Auth::id();
        $like = Like::where('user_id', $userId)
            ->where('item_id', $itemId)
            ->first();
        if ($like) {
            $like->delete();
            return redirect()->back()->with('success', 'お気に入りを削除しました');
        } else {
            return redirect()->back()->with('error', 'お気に入りが見つかりませんでした');
        }
    }

    // マイページ表示
    public function mypage()
    {
        $user = Auth::user();
        $likes = Like::where('user_id', $user->id)->with('item')->get();
        $itemsSelling = Item::where('user_id', $user->id)->get();
        $itemsPurchased = Item::where('sold_user_id', $user->id)->get();
        
        return view('auth.mypage', [
            'user' => $user,
            'likes' => $likes,
            'itemsSelling' => $itemsSelling,
            'itemsPurchased' => $itemsPurchased,
        ]);
    }
}
