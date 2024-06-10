@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/comment.css') }}"
@endsection

@section('content')
<div class="item-detail">
    <div class="item-info">
        <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" style="max-width: 300px;">
        <h2>{{ $item->name }}</h2>
        <p>{{ $item->brand }}</p>
        <p>価格:￥{{ $item->price }}（税込）</p>
        <form id="like-form" method="POST" action="{{ route('likes.like', $item->id )}}" style="display: {{ $isLiked ? 'none' : 'inline' }}">
            @csrf
            <button type="submit" class="btn btn-link p-0">
                <i class="far fa-star" style="font-size: 2rem;"></i>
            </button>
        </form>
        <form id="unlike-form" method="POST" action="{{ route('likes.unlike', $item->id ) }}" style="display: {{ $isLiked ? 'inline' : 'none' }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link p-0">
                <i class="fas fa-star" style="font-size: 2rem;"></i>
            </button>
        </form>
        <p>{{ $likeCount }}</p>
        <a href="{{ route('comments.show', ['item' => $item->id]) }}" class="btn btn-link p-0" {{ Auth::check() ? '' : 'disabled' }}>
            <i class="fas fa-comment" style="font-size: 2rem;"></i>
        </a>
        <p>{{ $commentCount }}</p>
    </div>

<div class="item-comments">
    <h2>コメント一覧</h2>
    @foreach($comments as $comment)
        <div class="comment">
            @if($comment->userProfile)
                @if($comment->user_id === $item->user_id)
                    <div class="comment-right">
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

@section('js')
<script>
    document.addEvetListener('DOMContentLoaded', function() {
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
    })
</script>
@endsection