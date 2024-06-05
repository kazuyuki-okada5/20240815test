@extends('layouts.app')

@section('content')
<div class="container">
    <div class="profile-header">
        <img src="{{ asset('storege/' . $user->profile_image) }}" alt="{{ $user->name }}" class="profile-image">
        <h2>{{ $user->name }}</h2>
        <a href="{{ route('profile.show') }}" class="btn btn-secondary">プロフィールを表示</a>
    </div>

    <div class="item-history">
        <button class="btn btn-secondary" id="show-selling">出品した商品</button>
        <button class="btn btn-secondary" id="show-purchased">購入した商品</button>
    </div>

    <h1>お気に入りリスト</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach ($likes as $like)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset('storage/' . $like->item->image_url) }}" class="card-img-too" alt="{{ $like->item->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $like->item->name }}</h5>
                        <p class="card-text">{{ $like->item->price }}円</p>
                        <a href="{{ route('items.show', $like->item->id) }}" class="btn btn-primary">詳細を見る</a>
                        <form method="POST" action="{{ route('likes.unlike', $like->item->id) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">お気に入り解除</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection