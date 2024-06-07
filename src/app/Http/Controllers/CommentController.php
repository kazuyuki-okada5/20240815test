<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Item;

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
            'item_id' => $itemid,
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('items.show', $itemId)->with('success', 'コメントが追加されました');
    }

    //　コメント表示
    public function showCommentForm($item_id)
    {
        $item = Item::findOrFail($item_id);
        $comments = Comment::where('item_id', $item_id)->with('user')->get();

        return view('items.comment', compact('item', 'comments'));
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
