@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/detail.css') }}">
@endsection

@section('content')
<div class="listtype__content"></div>
<div class="item-container">
    <div class="item-image">
        <img class="img" src="{{ asset('storage/' . $item->image_url) }}" alt="Item Image">
    </div>
    <div class="item-info">
        <h2 class="name">{{ $item->name }}</h2>
        <p class="brand">{{ $item->brand }}</p>
        <p class="price">￥{{ $item->price }}（税込）送料込み</p>
        <div class="buttons-container">
            <div class="like-container">
                <form id="like-form" method="POST" action="{{ route('likes.like', $item->id) }}" style="display: {{ $isLiked ? 'none' : 'inline' }}">
                    @csrf
                    <button type="submit" class="btn btn-link">
                        <i class="far fa-star" style="font-size: 2rem;"></i>
                    </button>
                </form>
                <form id="unlike-form" method="POST" action="{{ route('likes.unlike', $item->id) }}" style="display: {{ $isLiked ? 'inline' : 'none' }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link" {{ Auth::check() ? '' : 'disabled' }}>
                        <i class="fas fa-star" style="font-size: 2rem;"></i>
                    </button>
                </form>
                <p class="count">{{ $likeCount }}</p>
            </div>
            <div class="comment-container">
                <a href="{{ route('comments.show', ['item' => $item->id]) }}" class="btn btn-link" {{ Auth::check() ? '' : 'disabled' }}>
                    <i class="fas fa-comment" style="font-size: 2rem;"></i>
                </a>
                <p class="count">{{ $commentCount ?? '' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('items.buy', $item->id) }}">
            @csrf
            <button type="submit" class="btn btn-primary">購入する</button>
        </form>
        <p class="name">商品説明</p>
        <p class="explanation">{{ $item->comment }}</p>
        <p class="name">商品の情報</p>
        <p class="item-category">カテゴリー:</p>
        <p class="category-parts">
            @foreach ($item->categories as $category)
                <span>{{ $category->category }}</span>
            @endforeach
        </p>
        <p class="item-category">商品の状態:</p>
        <p class="category-parts"><span>{{ $item->condition->condition }}</span></p>
        <p class="item-category">出品者:{{ $user }}</p>
    </div>
</div>
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
            e.preventDefault();
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
