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
                <li class="listtype-nav__item">
                    <button class="listtype-nav__button" id="show-available">販売中</button>
                </li>
                @if (Auth::check())
                <li class="listtype-nav__item">
                    <button class="listtype-nav__button" id="show-likes">マイリスト</button>
                </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- おすすめアイテム一覧 -->
    <div id="item-list" class="item-container">
        @foreach($items as $item)
        <div class="item">
            <a href="{{ route('items.show', $item->id )}}">
                <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top" alt="{{ $item->name }}">
                @if($item->sold_user_id)
                <div class="sold-out">SOLD-OUT</div>
                @endif
            </a>
            <p class="card-text">
                @if($item->sold_user_id)
                    <span>売り切れ</span>
                @else
                    <span>{{ $item->price }}円</span>
                @endif
            </p>
            <p class="card-title">{{ $item->name }}</p>
        </div>
        @endforeach
    </div>

    @if (Auth::check())
    <!-- お気に入り一覧 -->
    <div id="likes-list" class="item-container hidden">
        @foreach ($likes as $like)
        <div class="item">
            <a href="{{ route('items.show', $like->item->id )}}">
                <img src="{{ asset('storage/' . $like->item->image_url) }}" class="card-img-top" alt="{{ $like->item->name }}">
                @if($like->item->sold_user_id)
                <div class="sold-out">SOLD-OUT</div>
                @endif
            </a>
            <p class="card-text">
                @if($like->item->sold_user_id)
                    <span>売り切れ</span>
                @else
                    <span>{{ $like->item->price }}円</span>
                @endif
            </p>
            <p class="card-title">{{ $like->item->name }}</p>
        </div>
        @endforeach
    </div>
    @endif

    <!-- 販売中リスト -->
    <div id="available-list" class="item-container hidden">
        @foreach($items as $item)
        @if (!$item->sold_user_id)
        <div class="item">
            <a href="{{ route('items.show', $item->id )}}">
                <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top" alt="{{ $item->name }}">
            </a>
            <p class="card-text">
                <span>{{ $item->price }}円</span>
            </p>
            <p class="card-title">{{ $item->name }}</p>
        </div>
        @endif
        @endforeach
    </div>
</div>

<script>
    document.getElementById('show-items').addEventListener('click', function(){
        document.getElementById('item-list').classList.remove('hidden');
        if (document.getElementById('likes-list')) {
            document.getElementById('likes-list').classList.add('hidden');
        }
        document.getElementById('available-list').classList.add('hidden');

        document.getElementById('show-items').classList.add('selected');
        if (document.getElementById('show-likes')) {
            document.getElementById('show-likes').classList.remove('selected');
        }
        document.getElementById('show-available').classList.remove('selected');
    });

    if (document.getElementById('show-likes')) {
        document.getElementById('show-likes').addEventListener('click', function(){
            document.getElementById('item-list').classList.add('hidden');
            document.getElementById('likes-list').classList.remove('hidden');
            document.getElementById('available-list').classList.add('hidden');

            document.getElementById('show-items').classList.remove('selected');
            document.getElementById('show-likes').classList.add('selected');
            document.getElementById('show-available').classList.remove('selected');
        });
    }

    document.getElementById('show-available').addEventListener('click', function(){
        document.getElementById('item-list').classList.add('hidden');
        if (document.getElementById('likes-list')) {
            document.getElementById('likes-list').classList.add('hidden');
        }
        document.getElementById('available-list').classList.remove('hidden');

        document.getElementById('show-items').classList.remove('selected');
        if (document.getElementById('show-likes')) {
            document.getElementById('show-likes').classList.remove('selected');
        }
        document.getElementById('show-available').classList.add('selected');
    });
</script>
@endsection






