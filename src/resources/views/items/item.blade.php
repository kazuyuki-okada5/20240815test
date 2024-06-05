@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/item.css') }}">
@endsection

@section('content')

<div class="listtype__content">
  <div class="listtype__list">
    <ul class="listtype-nav">
      <li class="listtype-nav__item">
        <button class="listtype-nav__button" id="show-items">おすすめ</button>
      </li>

      @if (Auth::check())
      <li class="listtype-nav__item">
        <button class="listtype-nav__button" id="show-likes">マイリスト</button>
      @endif
    </ul>
  </div>
</div>

<!--アイテム一覧-->
<div id="item-list" class="row mt-4">
  <h3>アイテム一覧</h3>
  @foreach($items as $item)
  <div class="col-md-4">
    <div class="card mb-4">
      <a href="{{ route('items.show', $item->id )}}">
        <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top" alt="{{ $item->name }}">
      </a>
      <div class="card-body">
        <h5 class="card-title">{{ $item->name }}</h5>
        <p class="card-text">{{ $item->price }}円</p>
      </div>
    </div>
  </div>
  @endforeach
</div>

@if (Auth::check())
<!-- お気に入り一覧 -->
<div id="likes-list" class="row mt-4" style="display: none;">
  <h3>マイリスト一覧</h3>
  @foreach ($likes as $like)
  <div class="col-md-4">
    <div class="card mb-4">
      <a href="{{ route('items.show', $like->item->id )}}">
        <img src="{{ asset('storage/' . $like->item->image_url) }}" class="card-img-top" alt="{{ $like->item->name }}">
      </a>
      <div class="card-body">
        <h5 class="card-title">{{ $like->item->name }}</h5>
        <p class="card-text">{{ $like->item->price }}円</p>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endif

<script>
  document.getElementById('show-items').addEventListener('click', function(){
    document.getElementById('item-list').style.display = 'block';
    if (document.getElementById('likes-list')) {
        document.getElementById('likes-list').style.display = 'none';
    }
  });

  if (document.getElementById('show-likes')) {
    document.getElementById('show-likes').addEventListener('click', function(){
      document.getElementById('item-list').style.display = 'none';
      document.getElementById('likes-list').style.display = 'block';
    });
  }
</script>
@endsection
