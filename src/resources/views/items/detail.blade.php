@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/detail.css') }}">
@endsection

@section('content')
<h1>商品の詳細〜Item Deteail〜</h1>
<div class="listtype__content"></div>
<div class="item-container">
    <div class="item-image">
        <img src="{{ $item->image_url }}" class="card-img-top" alt="{{ $item->name }}">
        @if ($item->sold_user_id !== null)
            <div class="sold-out-overlay">SOLD-OUT</div>
        @endif
    </div>
    <div class="item-info">
        <p class="name">{{ $item->name }}</p>
        <p class="brand">{{ $item->brand }}</p>
        @if ($item->sold_user_id !== null)
            <p class="price">売り切れ</p>
        @else
            <p class="price">￥{{ $item->price }}（税込）送料込み</p>
        @endif
        <div class="buttons-container">
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
                <a href="{{ route('comments.show', ['item' => $item->id]) }}" class="btn btn-link" {{ Auth::check() ? '' : 'disabled' }}>
                    <i class="fas fa-comment" style="font-size: 2rem;"></i>
                </a>
                <p class="count">{{ $commentCount ?? '' }}</p>
            </div>
        </div>
        @if ($item->sold_user_id === null)
            @if (Auth::check())
                <form method="GET" action="{{ route('items.buy', $item->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">購入手続きへ</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">購入手続きへ</a>
            @endif
        @else
            <button class="btn btn-secondary" disabled>売り切れました</button>
        @endif
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
@endsection