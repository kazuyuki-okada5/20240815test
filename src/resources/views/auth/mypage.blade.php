@extends('layouts.app')

@section('content')
<div class="container">
    <div class="profile-header">
        @if ($user->profile && $user->profile->img_url)
            <img src="{{ asset('storage/' . $user->profile->img_url) }}" alt="{{ $user->name }}"  style="max-width: 200px;">
        @else
            <div class="default-avater">
                <i class="fas fa-user-circle" style="font-size: 100px";></i>
            </div>
        @endif

        <h2>{{ $user->name }}</h2>
    @if (!$user->profile)
        <div class="alert alert-warning" role="alert">
            プロフィールが存在しません。プロフィールを作成してください。
        </div>
        <a href="{{ route('profile.create') }}" class="btn btn-primary">プロフィールを作成</a>
    @else
        <a href="{{ route('profile.show') }}" class="btn btn-secondary">プロフィールを表示</a>
    @endif
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
                    <a href="{{ route('items.show', $item->id) }}">
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