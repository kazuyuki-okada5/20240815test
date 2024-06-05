@extends('layouts.app')

@section('content')
<div class="container">
    <div class="profile-header">
        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="profile-image">
        <h2>{{ $user->name }}</h2>
        <a href="{{ route('profile.show') }}" class="btn btn-secondary">プロフィールを表示</a>
    </div>

    <div class="item-history">
        <button class="btn btn-secondary" id="show-selling">出品した商品</button>
        <button class="btn btn-secondary" id="show-purchased">購入した商品</button>
    </div>

    <!-- 出品した商品一覧 -->
    <div id="selling-items" class="row mt-4">
        @foreach ($itemsSelling as $item)
            <div class="col-mb-4">
                <div class="card mb-4">
                    <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top" alt="{{ $item->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">{{ $item->price }}円</p>
                        <a href="{{ route('items.show', $item->id) }}" class="btn btn-primary">詳細を見る</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 購入した商品一覧 -->
    <div id="purchased-items" class="row mt-4" style="display: none;">
        <h3>購入した商品一覧</h3>
        @foreach ($itemsPurchased as $item)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top" alt="{{ $item->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">{{ $item->price }}円</p>
                        <a href="{{ route('items.show', $item->id) }}" class="btn btn-primary">詳細を見る</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.getElementById('show-selling').addEventListener('click', function(){
        document.getElementById('selling-items').style.display = 'block';
        document.getElementById('purchased-items').style.display = 'none';
    });

    document.getElementById('show-purchased').addEventListener('click', function(){
        document.getElementById('selling-items').style.display = 'none';
        document.getElementById('purchased-items').style.display = 'none';
    });
</script>
@endsection