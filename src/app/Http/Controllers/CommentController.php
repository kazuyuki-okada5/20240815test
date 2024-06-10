<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Like;

class CommentController extends Controller
{
    //　コメント作成
    public function create($itemId)
    {
        $item = Item::findOrFail($itemId);
        return view('items.comment', compact('item'));
    }

    public function store(Request $request, $itemId)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'item_id' => $itemId,
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('items.show', $itemId)->with('success', 'コメントが追加されました');
    }

    //　コメント表示
    public function showCommentForm($item_id)
    {
        $item = Item::findOrFail($item_id);
        $comments = Comment::where('item_id', $item_id)->with('user')->get();

        //　ユーザーのプロフィール情報を取得
        foreach ($comments as $comment) {
            $comment->userProfile = Profile::where('user_id', $comment->user_id)->first();
        }

        //　お気に入り情報とコメント数を取得
        $isLiked = Auth::check() && Auth::user()->likes()->where('item_id', $item_id)->exists();
        $likeCount = Like::where('item_id', $item_id)->count();
        $commentCount = Comment::where('item_id', $item_id)->count();

        return view('items.comment', compact('item', 'comments', 'isLiked', 'likeCount', 'commentCount'));
    }

    public function storeComment(Request $request, $item_id)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->item_id = $item_id;
        $comment->comment = $request->comment;
        $comment->save();
        
        return redirect()->route('comments.show', ['item' => $item_id])->with('success', 'コメントを投稿しました');
    }
}
