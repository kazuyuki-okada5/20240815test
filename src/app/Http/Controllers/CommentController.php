<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Like;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    // コメント表示
    public function showCommentForm($item_id)
    {
        $item = Item::findOrFail($item_id);
        $comments = Comment::where('item_id', $item_id)->with('user')->get();
        foreach ($comments as $comment) {
            $comment->userProfile = Profile::where('user_id', $comment->user_id)->first();
        }
        $isLiked = Auth::check() && Auth::user()->likes()->where('item_id', $item_id)->exists();
        $likeCount = Like::where('item_id', $item_id)->count();
        $commentCount = Comment::where('item_id', $item_id)->count();

        return view('items.comment', compact('item', 'comments', 'isLiked', 'likeCount', 'commentCount'));
    }

    // コメント投稿
    public function storeComment(CommentRequest $request, $item_id)
    {
        $validated = $request->validated();
        $lastComment = Comment::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
        if ($lastComment && $lastComment->created_at->diffInSeconds(now()) < 3) {
            return redirect()->back()->withErrors(['comment' => '短時間での連続投稿はできません。']);
        }

        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->item_id = $item_id;
        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->route('comments.show', ['item' => $item_id])->with('success', 'コメントを投稿しました');
    }
}
