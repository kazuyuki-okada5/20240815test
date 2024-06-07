@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/buy.css') }}">
@endsection

@section('content')

<div class="buy-container">
    <h1>商品購入</h1>
    <div class="item-image">
        <img src="{{ asset('storage/' . $item->image_url) }}" alt="Item Image" style="max-width: 300px">
    </div>
    <div class="item-info">
        <h2>商品名: {{ $item->name }}</h2>
        <p>価格:￥{{ $item->price }}</p>
    </div>
    <div class="payment-method">
        <h2>支払い方法変更</h2>
        <!-- 支払い方法変更フォーム -->
        <form action="{{ route('payment.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- 支払い方法の選択肢 -->
            <!-- ここに支払い方法の選択肢を追加 -->
            <!-- 例: <input type="radio" name="payment_method" value="クレジットカード"> クレジットカード -->
            <button type="submit" class="btn btn-primary">変更する</button>
        </form>
    </div>
    <div class="shipping-address">
        <h2>配送先変更</h2>
        <!-- 配送先変更フォーム -->
        <form action="{{ route('shipping.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- 配送先の選択肢 -->
            <!-- ここに配送先の選択肢を追加 -->
            <!-- 例: <input type="radio" name="shipping_address" value="自宅"> 自宅 -->
            <button type="submit" class="btn btn-primary">変更する</button>
        </form>
    </div>
    <div class="purchase-button">
        <form action="{{ route('purchase.complete', $item->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">購入する</button>
        </form>
    </div>
</div>

@endsection