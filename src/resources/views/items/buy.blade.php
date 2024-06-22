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
    <div class="shipping-address">
        <h2>配送先変更</h2>
        <!-- 配送先の選択肢リスト -->
        <form action="{{ route('shipping.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="shipping_address">配送先を選択してください</label>
                <select name="shipping_address" id="shipping_address" class="form-control">
                    <!-- ユーザープロフィールの初期選択肢 -->
                    <option value="{{ $profile['post_code'] . ' ' . $profile['address'] . ' ' . $profile['building'] }}">
                        {{ $profile['post_code'] }} {{ $profile['address'] }} {{ $profile['building'] }}
                    </option>
                    <!-- 登録された配送先の選択肢 -->
                    @foreach($shippingChanges as $shipping)
                        <option value="{{ $shipping->post_code . ' ' . $shipping->address . ' ' . $shipping->building }}">
                            {{ $shipping->post_code }} {{ $shipping->address }} {{ $shipping->building }}
                        </option>
                    @endforeach
                </select>
            </div>

        </form>
                <!-- 追加するボタン -->
        <form action="{{ route('shipping.change.show', $item->id) }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-secondary">追加する</button>
        </form>
    </div>
    <div class="purchase-button">
        <form action="{{ route('items.buy.post', $item->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">購入する</button>
        </form>
    </div>
</div>

@endsection