@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/comment.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="item-detail">
    <div class="item-info">
        <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" style="max-width: 300px;">
        <p class="name">{{ $item->name }}</p>
        <p class="brand">{{ $item->brand }}</p>
        <p class="price">価格:￥{{ $item->price }}（税込）</p>
        <div class="like-container">
            <form id="like-form" method="POST" action="{{ route('likes.like', $item->id )}}" style="display: {{ $isLiked ? 'none' : 'inline' }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 like-button">
                    <i class="far fa-star" style="font-size: 2rem;"></i>
                </button>
            </form>
            <form id="unlike-form" method="POST" action="{{ route('likes.unlike', $item->id ) }}" style="display: {{ $isLiked ? 'inline' : 'none' }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link p-0 like-button">
                    <i class="fas fa-star" style="font-size: 2rem;"></i>
                </button>
            </form>
            <p class="like-count">{{ $likeCount }}</p>
        </div>
        <div class="comment-container">
            <a href="{{ route('comments.show', ['item' => $item->id]) }}" class="btn btn-link p-0 comment-button" {{ Auth::check() ? '' : 'disabled' }}>
                <i class="fas fa-comment" style="font-size: 2rem;"></i>
            </a>
            <p class="comment-count">{{ $commentCount }}</p>
        </div>
    </div>

    <div class="item-comments">
        <h2 class="commnent-list">コメント一覧</h2>
@foreach($comments as $comment)
    <div class="comment">
        @if($comment->userProfile)
            @if($comment->user_id === $item->user_id)
                <div class="comment-right">
                    @if($comment->userProfile->img_url)
                        <img src="{{ asset('storage/' . $comment->userProfile->img_url) }}" class="comment-avatar" alt="{{ $comment->userProfile->name }}">
                    @else
                        <div class="default-avatar">
                            <i class="fas fa-user-circle"></i><!-- 代替えアイコン -->
                        </div>
                    @endif
                        <p class="comment"><strong>{{ $comment->userProfile->name }}</strong></p>
                        <p class="date-right">（{{ $comment->created_at->format('Y-m-d H:i') }}）</p>
                </div>
                <div class="comment-text-right">
                    <p class="comment">{{ $comment->comment }}</p>
                </div>
            @else
                <div class="comment-left">
                    @if($comment->userProfile->img_url)
                        <img src="{{ asset('storage/' . $comment->userProfile->img_url) }}" class="comment-avatar" alt="{{ $comment->userProfile->name }}">
                    @else
                        <div class="default-avatar">
                            <i class="fas fa-user-circle"></i><!-- 代替えアイコン -->
                        </div>
                    @endif
                        <p class="comment"><strong>{{ $comment->userProfile->name }}</strong></p>
                        <p class="date-left">（{{ $comment->created_at->format('Y-m-d H:i') }}）</p>
                </div>
                <div class="comment-text-left">
                    <p class="comment">{{ $comment->comment }}</p>
                </div>
            @endif
        @else
            <!-- ユーザープロファイルが存在しない場合の処理 -->
            <div class="comment-left">
                <div class="default-avatar">
                    <i class="fas fa-user-circle"></i><!-- 代替えアイコン -->
                </div>
                <div>
                    <p class="date-left">（{{ $comment->created_at->format('Y-m-d H:i') }}）</p>
                </div>
            </div>
            <div class="comment-text-left">
                <p class="comment">{{ $comment->comment }}</p>
            </div>
        @endif
    </div>
@endforeach


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
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var isLiked = @json($isLiked);
        var likeForm = document.getElementById('like-form');
        var unlikeForm = document.getElementById('unlike-form');

        likeForm.addEventListener('submit', function(e) {
            if (!@json(Auth::check())) {
                e.preventDefault();
                alert('この操作を行うにはログインが必要です。');
                return false;
            }

            e.preventDefault();
            if (!isLiked) {
                likeForm.submit();
                likeForm.style.display = 'none';
                unlikeForm.style.display = 'inline';
                isLiked = true;
            }
        });

        unlikeForm.addEventListener('submit', function(e) {
            if (!@json(Auth::check())) {
                alert('この操作を行うにはログインが必要です。');
                return false;
            }

            e.preventDefault();
            if (isLiked) {
                unlikeForm.submit();
                unlikeForm.style.display = 'none';
                likeForm.style.display = 'inline';
                isLiked = false;
            }
        });
    });
</script>
@endsection
