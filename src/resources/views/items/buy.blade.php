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
        <div class="content-container">
            <div class="left-container">
                <div class="item-image">
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="Item Image" class="item-image-element">
                </div>
                <div class="item-info">
                    <h2>商品名: {{ $item->name }}</h2>
                    <p>価格: ￥{{ $item->price }}</p>
                </div>
                <div class="payment-method">
                    <div class="form-group">
                        <label for="payment_method">支払い方法を選択してください</label>
                        <select name="payment_method" id="payment_method" class="form-control" onchange="updatePaymentMethod()">
                            <option value="" disabled selected>支払い方法を選択してください</option>
                            <option value="credit_card">クレジットカード</option>
                            <option value="convenience_store">コンビニ</option>
                            <option value="bank_transfer">銀行振込</option>
                        </select>
                        @if ($errors->has('payment_method'))
                            <span class="text-danger">{{ $errors->first('payment_method') }}</span>
                        @endif
                    </div>
                </div>
                <div class="shipping-address">
                    <div class="form-group">
                        <label for="shipping_address">配送先を選択してください</label>
                        <select name="shipping_address" id="shipping_address" class="form-control" onchange="updateShippingAddress()">
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
                        @if ($errors->has('shipping_address'))
                            <span class="text-danger">{{ $errors->first('shipping_address') }}</span>
                        @endif
                    </div>
                    <!-- 配送先変更ボタン -->
                    <form action="{{ route('shipping.change.show', $item->id) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-secondary">配送先を追加する</button>
                    </form>
                </div>
            </div>

            <!-- 確認コンテナ -->
            <div class="confirmation-container">
                <h2>確認</h2>
                <p>商品代金: ￥{{ $item->price }}</p>
                <p>選択された支払い方法: </span></p>
                <p><span id="selected_payment_method"></p>
                <p>選択された配送先:</p>
                <p>〒: <span id="selected_shipping_postcode"></span></p>
                <p>住所: <span id="selected_shipping_address"></span></p>
                <p>建物名: <span id="selected_shipping_building"></span></p>
                <p>合計金額: ￥{{ $item->price }}</p>
                <form method="POST" action="{{ route('items.purchase', $item->id) }}">
                    @csrf
                    <input type="hidden" name="payment_method" id="confirmation_payment_method">
                    <input type="hidden" name="shipping_address" id="confirmation_shipping_address">
                    <button type="submit" class="btn btn-success">購入する</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // 選択された支払い方法を表示する
        function updatePaymentMethod() {
            var paymentMethod = document.getElementById("payment_method").value;
            var paymentText = "";
            switch (paymentMethod) {
                case 'credit_card':
                    paymentText = "クレジットカード";
                    break;
                case 'convenience_store':
                    paymentText = "コンビニ";
                    break;
                case 'bank_transfer':
                    paymentText = "銀行振込";
                    break;
            }
            document.getElementById("selected_payment_method").innerText = paymentText;
            document.getElementById("confirmation_payment_method").value = paymentMethod;
        }

        // 選択された配送先を表示する
        function updateShippingAddress() {
            var shippingAddress = document.getElementById("shipping_address").value.split(' ');
            document.getElementById("selected_shipping_postcode").innerText = shippingAddress[0];
            document.getElementById("selected_shipping_address").innerText = shippingAddress[1];
            document.getElementById("selected_shipping_building").innerText = shippingAddress[2] || '';
            document.getElementById("confirmation_shipping_address").value = document.getElementById("shipping_address").value;
        }

        // 初期表示
        document.addEventListener('DOMContentLoaded', function() {
            updatePaymentMethod();
            updateShippingAddress();
        });
    </script>
@endsection





