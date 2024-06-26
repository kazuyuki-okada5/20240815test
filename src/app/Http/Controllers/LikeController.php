<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($itemId)
    {
        $userId = Auth::id();

        // ユーザーが既にお気に入りに追加しているか確認する
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
        } else {
            return redirect()->back()->with('error', 'すでにお気に入りに追加されています');
        }
    }

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
            return redirect()->back()->with('error', 'いいねが見つかりませんでした');
        }
    }



    public function index()
    {
        $user = Auth::user();//　現在のユーザー情報を取得
        $likes = Like::where('user_id', Auth::id())->with('item')->get();//　ユーザーのお気に入りを取得

        return view('likes.index', ['user' => $user, 'likes' => $likes]);
    }

    public function mypage()
    {
        $user = Auth::user();
        $likes = Like::where('user_id', $user->id)->with('item')->get();
        $itemsSelling = Item::where('user_id', $user->id)->get();
        $itemsPurchased = Item::where('sold_user_id', $user->id)->get();

        return view('auth.mypage',[
            'user' => $user,
            'likes' => $likes,
            'itemsSelling' => $itemsSelling,
            'itemsPurchased' => $itemsPurchased,
        ]);
    }
}
