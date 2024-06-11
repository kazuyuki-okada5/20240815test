@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/item.css') }}">
@endsection

@section('content')
<div class="central-container">
    <div class="listtype__content">
        <div class="listtype__list">
            <ul class="listtype-nav">
                <li class="listtype-nav__item">
                    <button class="listtype-nav__button selected" id="show-items">おすすめ</button>
                </li>
                @if (Auth::check())
                <li class="listtype-nav__item">
                    <button class="listtype-nav__button" id="show-likes">マイリスト</button>
                </li>
                @endif
            </ul>
        </div>
    </div>

    <!--アイテム一覧-->
    <div id="item-list" class="item-container">
        @foreach($items as $item)
        <div class="item card-img-top">
            <div class="item">
                <a href="{{ route('items.show', $item->id )}}">
                    <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top" alt="{{ $item->name }}">
                </a>
                <p class="card-text"><span>{{ $item->price }}円</span></p>
                <div class="card-body">
                    <h2 class="card-title">{{ $item->name }}</h2>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if (Auth::check())
    <!-- お気に入り一覧 -->
    <div id="likes-list" class="item-container hidden">
        @foreach ($likes as $like)
        <div class="item card-img-top">
            <div class="item">
                <a href="{{ route('items.show', $like->item->id )}}">
                    <img src="{{ asset('storage/' . $like->item->image_url) }}" class="card-img-top" alt="{{ $like->item->name }}">
                </a>
                <p class="card-text"><span>{{ $like->item->price }}円</span></p>
                <div class="card-body">
                    <h2 class="card-title">{{ $like->item->name }}</h2>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
    document.getElementById('show-items').addEventListener('click', function(){
        document.getElementById('item-list').style.display = 'block';
        if (document.getElementById('likes-list')) {
            document.getElementById('likes-list').style.display = 'none';
        }
        document.getElementById('show-items').classList.add('selected');
        document.getElementById('show-likes').classList.remove('selected');
    });

    document.getElementById('show-likes').addEventListener('click', function(){
        document.getElementById('item-list').style.display = 'none';
        if (document.getElementById('likes-list')) {
            document.getElementById('likes-list').style.display = 'block';
        }
        document.getElementById('show-items').classList.remove('selected');
        document.getElementById('show-likes').classList.add('selected');
    });
</script>
@endsection



