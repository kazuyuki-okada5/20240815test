@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/detail.css') }}">

@endsection

@section('content')

<div class="listtype__content">
  <div class="listtype__list">
          <ul class="listtype-nav">
            <li class="listtype-nav__item">
              <form class="form" action='/' method="get">
                @csrf
                <button class="listtype-nav__button">おすすめ</button>
              </form>
            </li>
            @if (Auth::check())
            <li class="listtype-nav__item">
              <form class="form" action='/item/{item_id}' method="get">
                @csrf
                <button class="listtype-nav__button">マイリスト</button>
              </form>
            </li>
            @endif
          </ul>
    </div>
  </div>
  <div class="item-container">
    <h1>アイテム詳細</h1>
        <div class="item-image">
            <img src="{{ asset('storage/' . $item->image_url) }}" alt="Item Image" style="max-width: 300px;">
        </div>
        <div class="item-info">
            <h2>商品名:{{ $item->name }}</h2>
            <p>ブランド名:{{ $item->brand }}</p>
            <p>￥{{ $item->price }}（税込）送料込み</p>
    <form id="like-form" method="POST" action="{{ route('likes.like', $item->id) }}" style="display: {{ $isLiked ? 'none' : 'inline' }}">
      @csrf
      <button type="submit" class="btn btn-link p-0">
        <i class="far fa-star" style="font-size: 2rem;"></i>
      </button>
    </form>
    <form id="unlike-form" method="POST" action="{{ route('likes.unlike', $item->id) }}" style="display: {{ $isLiked ? 'inline' : 'none' }}">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-link p-0">
        <i class="fas fa-star" style="font-size: 2rem;"></i>
      </button>
    </form>
            <p>{{ $likeCount }}</p>
    <a href="{{ route('comments.show', ['item' => $item->id]) }}" class="btn btn-link p-0">
      <i class="fas fa-comment" style="font-size: 2rem;"></i>
    </a>
            <p>{{ $commentCount ?? '' }}</p>
            <form method="POST" action="{{ route('items.buy', $item->id) }}">
              @csrf
            <button type="submit" class="btn btn-primary">購入する</button>
            </form>
            <p>商品説明<br>
                {{ $item->comment }}</p>
            <p>商品の情報</p>
            <p>カテゴリー:
              @foreach ($item->categories as $category)
                {{ $category->category }}
              @endforeach
            </p>
            <p>商品の状態:{{ $item->condition->condition }}</p>
            <p>出品者:{{ $user }}</p>
        </div>
  </div>
  <!-- 戻るボタン -->
    <a href="{{ route('items.index') }}">戻る</a>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var isLiked = @json($isLiked);
    var likeForm = document.getElementById('like-form');
    var unlikeForm = document.getElementById('unlike-form');

    likeForm.addEventListener('submit', function(e) {
      e.preventDefault();
      if (!isLiked) {
        likeForm.submit();
        likeForm.style.display = 'none';
        unlikeForm.style.display = 'inline';
        isLiked = true;
      }
    });

    unlikeForm.addEventListener('submit', function(e) {
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