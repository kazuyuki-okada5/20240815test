@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/search.css') }}">
@endsection

@section('content')
<div class="container">
    <h1>検索結果</h1>
    @if($items->isEmpty())
        <p>該当するアイテムがありません</p>
    @else
        <div class="list-conteneres">
            @foreach ($items as $item)
                <div class="conteneres">
                    <div class="list">
                        <a href="{{ route('items.show', $item->id) }}">
                            <img src="{{ asset('storage/' . $item->image_url) }}" class="card-img-top" alt="{{ $item->name }}">
                        </a>
                        <p class="card-text"><span>{{ $item->price }}円</span></p>
                        <div class="card-body">
                            <p class="card-title">{{ $item->name }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection