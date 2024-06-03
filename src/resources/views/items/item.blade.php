@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/item.css') }}">
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
    <h2>アイテム一覧</h2>
    <ul>
      @foreach($items as $item)
        <li>
          <form action="{{ route('item.show', ['item_id' => $item->id]) }}" method="get">
            <button type="submit" class="button">
              <img src="{{ asset('storage/' . $item->image_url) }}" alt="Item Image" style="max-width: 150px;">
            </button>
          </form>
          <p>価格: {{ $item->price }}円</p>
        </li>
      @endforeach
    </ul>
  </div>
</div>
@endsection