@extends('layouts.app')

@section('content')
<div class="container">
    <h1>検索結果</h1>
    @if($items->isEmpty())
        <p>該当するアイテムがありません</p>
    @else
        <div class="row">
            @foreach ($items as $item)
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
    @endif
</div>
@endsection