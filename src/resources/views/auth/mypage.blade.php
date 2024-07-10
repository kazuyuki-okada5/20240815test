@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/mypage.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="profile-header">
        @if ($user && $user->profile && $user->profile->img_url)
            <img class="profile-img" src="{{ asset('storage/' . $user->profile->img_url) }}" alt="{{ $user->name }}">
        @else
            <div class="default-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
        @endif

        <h1 class="name">{{ $user->name }}</h1>
        @if (!$user->profile)
            <div class="alert alert-warning" role="alert">
                プロフィールが存在しません。<br>プロフィールを作成してください。
            </div>
            <a href="{{ route('profile.create') }}" class="btn btn-primary">プロフィールを作成</a>
        @else
            <a href="{{ route('profile.show') }}" class="btn btn-secondary">プロフィールを表示</a>
        @endif
    </div>

    <div class="item-history">
        <button class="btn btn-secondary active" id="show-selling">出品した商品</button>
        <button class="btn btn-secondary" id="show-purchased">購入した商品</button>
    </div>

    <!-- 出品した商品一覧 -->
    <div class="item-box">
        <div id="selling-items" class="item-container">
            @foreach ($itemsSelling as $item)
                <div class="item">
                    <div class="card-body">
                        <a href="{{ route('items.show', $item->id) }}">
                            <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top" alt="{{ $item->name }}">
                        </a>
                        <p class="card-text"><span>{{ $item->price }}円</span></p>
                        <p class="card-title">{{ $item->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 購入した商品一覧 -->
        <div id="purchased-items" class="item-container hidden">
            @foreach ($itemsPurchased as $item)
                <div class="item">
                    <div class="card-body">
                        <a href="{{ route('items.show', $item->id) }}">
                            <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top" alt="{{ $item->name }}">
                        </a>
                        <p class="card-text"><span>{{ $item->price }}円</span></p>
                        <p class="card-title">{{ $item->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

    <script src="{{ asset('js/mypage.js') }}"></script>
@endsection


