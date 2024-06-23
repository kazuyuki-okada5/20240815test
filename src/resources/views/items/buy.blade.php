@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items/buy.css') }}">
@endsection

@section('content')
    <div class="buy-container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1>商品購入</h1>
        <div class="item-image">
            <img src="{{ asset('storage/' . $item->image_url) }}" alt="Item Image" style="max-width: 300px">
        </div>
        <div class="item-info">
            <h2>商品名: {{ $item->name }}</h2>
            <p>価格:￥{{ $item->price }}</p>
        </div>
        <form method="POST" action="{{ route('items.purchase', $item->id) }}">
            @csrf
            <div class="payment-method">
                <h2>支払い方法</h2>
                <div class="form-group">
                    <label for="payment_method">支払い方法を選択してください</label>
                    <select name="payment_method" id="payment_method" class="form-control">
                        <option value="credit_card">クレジットカード</option>
                        <option value="convenience_store">コンビニ</option>
                        <option value="bank_transfer">銀行振込</option>
                    </select>
                </div>
            </div>
        <div class="shipping-address">
            <h2>配送先</h2>
            <div class="form-group">
                <label for="shipping_address">配送先を選択してください</label>
                <select name="shipping_address" id="shipping_address" class="form-control">
                    <!-- ユーザープロフィールの初期選択肢 -->
                    <option value="{{ $profile['post_code'] . ' ' . $profile['address'] . ' ' . $profile['building'] }}">
                        郵便番号: {{ $profile['post_code'] }} - 住所: {{ $profile['address'] }} - 建物名: {{ $profile['building'] }}
                    </option>
                    <!-- 登録された配送先の選択肢 -->
                    @foreach($shippingChanges as $shipping)
                        <option value="{{ $shipping->post_code . ' ' . $shipping->address . ' ' . $shipping->building }}">
                            郵便番号: {{ $shipping->post_code }} - 住所: {{ $shipping->address }} - 建物名: {{ $shipping->building }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success">購入する</button>
        </form>
            <!-- 配送先変更ボタン -->
            <form action="{{ route('shipping.change.show', $item->id) }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-secondary">配送先を追加する</button>
            </form>
        </div>
@endsection
