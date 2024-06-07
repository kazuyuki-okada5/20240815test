@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/comment.css') }}"
@endsection

@section('content')
<div class="item-comments">
    <h1>コメント一覧</h1>
    @foreach($comments as $comment)
        <div class="comment">
            @if($comment->userProfile)
                @if($comment->user_id === $item->user_id)
                    <div class="commet-right">
                @else
                    <div class="comment-left">
                @endif
                    @if($comment->userProfile->img_url)
                        <img src="{{ asset('storage/' . $comment->userProfile->img_url) }}" style="max-width: 50px">
                    @else
                        <div class="default-avatar">
                            <i class="fas fa-user-circle"></i><!-- 代替えアイコン -->
                        </div>
                    @endif
                    <p><strong>{{ $comment->userProfile->name }}</strong></p>
                </div>
            @else
                <div class="comment-left">
                    <div class="default-avatar">
                        <i class="fas fa-user-circle"></i><!-- 代替えアイコン -->
                    </div>
                </div>
            @endif
            <div class="comment-text">
                <p>{{ $comment->comment }}</p>
            </div>
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