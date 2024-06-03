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
            <button>お気に入り</button>
            <p>お気に入り登録者数</p>
            <button>コメント</button>
            <p>コメント数</p>
            <button>購入する</button>
            <p>商品説明<br>
                {{ $item->comment }}</p>
            <p>商品の情報</p>
            <p>カテゴリー;</p>
            <p>商品の状態:{{ $item->condition_id}}</p>
            <p>出品者:{{ $user }}</p>
        </div>
  </div>
  <!-- 戻るボタン -->
    <a href="{{ route('items.index') }}">戻る</a>
</div>
@endsection