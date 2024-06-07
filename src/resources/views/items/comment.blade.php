@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/comment.css') }}"
@endsection

@section('content')
<div class="item-comments">
    <h1>コメント一覧</h1>
    @foreach($comments as $comment)
        <div class="comment">
            @if($comment->user_id === $item->user_id)
                <!-- 出品者がコメントした場合 -->
                <div class="comment-right">
                    <img src="{{ asset('storage/' . $comment->user->img_url) }}" style="max-width: 50px;">
                    <p><strong>{{ $comment->user->name }}</strong></p>
                </div>
                <div class="comment-text">
                    <p>{{ $comment->comment }}</p>
                </div>
            @else
                <!-- ユーザーがコメントした場合 -->
                <div class="comment-left">
                    <img src="{{ asset('storage/' . $comment->user->img_url) }}" style="max-width: 50px;">
                    <p><strong>{{ $comment->user->name }}</strong></p>
                </div>
                <div class="comment-text">
                    <p>{{ $comment->comment }}</p>
                </div>
            @endif
        </div>
    @endforeach

    <form method="POST" action="{{ route('comments.store', ['item' => $item->id]) }}">
        @csrf
        <div class="form-group">
            <label for="comment">商品へのコメント</label>
            <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">コメントを投稿</button>
    </form>
    <a href="{{ route('items.show', $item->id ) }}">戻る</a>
</div>
@endsection