@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/comment.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="item-detail">
    <div class="item-info">
        <div class="item-image-container">
            <img src="{{ $item->image_url }}" class="card-img-top" alt="{{ $item->name }}">
            @if($item->sold_user_id)
                <div class="sold-out-overlay">SOLD-OUT</div>
            @endif
        </div>
        <p class="name">{{ $item->name }}</p>
        <p class="brand">{{ $item->brand }}</p>
        <p class="price">{{ $item->sold_user_id ? '売り切れ' : '価格:￥' .$item->price . '(税込)' }}</p>
<div class="like-container">
    @if (Auth::check())
        <form id="like-form" method="POST" action="{{ route('likes.like', $item->id) }}" style="display: {{ $isLiked ? 'none' : 'inline' }}">
            @csrf
            <button type="submit" class="btn btn-link like-button">
                <i class="far fa-star" style="font-size: 2rem;"></i>
            </button>
        </form>
        <form id="unlike-form" method="POST" action="{{ route('likes.unlike', $item->id) }}" style="display: {{ $isLiked ? 'inline' : 'none' }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link like-button">
                <i class="fas fa-star" style="font-size: 2rem;"></i>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-link like-button">
            <i class="far fa-star" style="font-size: 2rem;"></i>
        </a>

    @endif
    <p class="count">{{ $likeCount }}</p>
</div>

        <div class="comment-container">
            <a href="{{ route('comments.show', ['item' => $item->id]) }}" class="btn btn-link p-0 comment-button" {{ Auth::check() ? '' : 'disabled' }}>
                <i class="fas fa-comment" style="font-size: 2rem;"></i>
            </a>
            <p class="comment-count">{{ $commentCount }}</p>
        </div>
    </div>
    <div class="item-comments">
        <h2 class="comment-list">コメント一覧</h2>
            <div class="alert alert-success">{{ session('success') }}</div>
        @foreach($comments as $comment)
            <div class="comment">
                @if($comment->user_id === $item->user_id)
                    <div class="comment-right">
                        @if($comment->userProfile && $comment->userProfile->img_url)
                            <img src="{{ asset('storage/' . $comment->userProfile->img_url) }}" class="comment-avatar-right" alt="{{ $comment->userProfile->name }}">
                        @else
                            <div class="default-avatar">
                                <i class="fas fa-user-circle"></i>
                            </div>
                        @endif
                        <p class="date-right">（{{ $comment->created_at->format('Y-m-d H:i') }}）</p>
                    </div>
                    <div class="comment-text-right">
                        <p class="comment">{{ $comment->comment }}</p>
                        @if(Auth::check() && Auth::user()->role == 0)
                            <form method="POST" action="{{ route('admin.comments.delete', $comment->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="comment-left">
                        @if($comment->userProfile && $comment->userProfile->img_url)
                            <img src="{{ asset('storage/' . $comment->userProfile->img_url) }}" class="comment-avatar-left" alt="{{ $comment->userProfile->name }}">
                        @else
                            <div class="default-avatar">
                                <i class="fas fa-user-circle"></i><!-- 代替えアイコン -->
                            </div>
                        @endif
                        <p class="date-left">（{{ $comment->created_at->format('Y-m-d H:i') }}）</p>
                    </div>
                    <div class="comment-text-left">
                        <p class="comment">{{ $comment->comment }}</p>
                        @if(Auth::check() && Auth::user()->role == 0)
                            <form method="POST" action="{{ route('admin.comments.delete', $comment->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
        @auth
            @if(is_null($item->sold_user_id))
            <form method="POST" action="{{ route('comments.store', ['item' => $item->id]) }}" class="comment-form">
                @csrf
                <div class="form-group">
                    <label for="comment">商品へのコメント</label>
                    <textarea name="comment" id="comment" class="form-control" rows="3" required>{{ old('comment') }}</textarea>
                    @if ($errors->has('comment'))
                        <div class="alert alert-danger">
                            <span class="error-message">{{ $errors->first('comment') }}</span>
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">コメントを投稿</button>
            </form>
            @else
                <p class="sold-out-required-message">購入後の品にコメントは出来ません。</p>
            @endif
        @else
            <p class="login-required-message">コメントを投稿するには<a href="{{ route('login') }}" class="login-link">ログイン</a>が必要です</p>
        @endauth
    </div>
</div>
@endsection


