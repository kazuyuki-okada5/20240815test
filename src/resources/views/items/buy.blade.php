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
        @if (session('error'))
    <div class="alert-danger-url">
        {{ session('error') }}
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
                @error('payment_method')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
                @error('shipping_address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
                <p>選択された支払い方法: <span id="selected_payment_method"></span></p>
                <p>選択された配送先:</p>
                <p>〒: <span id="selected_shipping_postcode"></span></p>
                <p>住所: <span id="selected_shipping_address"></span></p>
                <p>建物名: <span id="selected_shipping_building"></span></p>
                <p>合計金額: ￥{{ $item->price }}</p>
                <form method="POST" action="{{ route('items.purchase', $item->id) }}" id="purchase-form">
                    @csrf
                    <input type="hidden" name="payment_method" id="confirmation_payment_method">
                    <input type="hidden" name="shipping_address" id="confirmation_shipping_address">
                    <button type="submit" class="btn btn-success">購入する</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        @if (session('success_message'))
            <div class="alert alert-success">
                {{ session('success_message') }}
            </div>
        @endif
        @if (session('error_message'))
            <div class="alert alert-danger">
                {{ session('error_message') }}
            </div>
        @endif

        <form action="{{ route('charge') }}" method="post" id="payment-form">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="form-row">
                <div id="card-errors" role="alert"></div>
            </div>
            <div style="border: 1px solid #000;">
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>
            </div>
            <button class="btn btn-primary mt-3" id="credit-card-button">クレジットカード</button>
        </form>
        <button id="konbini-button" class="btn btn-primary mt-3">コンビニ</button>
        <button id="bank-transfer-button" class="btn btn-primary mt-3">銀行振込</button>
        <div id="payment-message" class="alert alert-info" style="display: none;"></div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        document.getElementById('konbini-button').addEventListener('click', function () {
            fetch('{{ route('create.konbini.payment.intent') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ item_id: {{ $item->id }} }) // ここにitem_idを追加
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (result) {
                if (result.error) {
                    var errorElement = document.getElementById('payment-message');
                    errorElement.textContent = result.error;
                    errorElement.style.display = 'block';
                } else {
                    stripe.confirmKonbiniPayment(result.clientSecret, {
                        payment_method: {
                            billing_details: {
                                name: 'Taro Yamada',
                                email: 'taro@example.com',
                            },
                        },
                    }).then(function (result) {
                        if (result.error) {
                            var errorElement = document.getElementById('payment-message');
                            errorElement.textContent = result.error.message;
                            errorElement.style.display = 'block';
                        } else {
                            var successElement = document.getElementById('payment-message');
                            successElement.textContent = 'Payment successful! Please proceed to the convenience store to complete your payment.';
                            successElement.style.display = 'block';
                        }
                    });
                }
            });
        });

        document.getElementById('bank-transfer-button').addEventListener('click', function () {
            fetch('{{ route('create.bank.transfer.payment.intent') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ item_id: {{ $item->id }} }) // ここにitem_idを追加
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (result) {
                if (result.error) {
                    var errorElement = document.getElementById('payment-message');
                    errorElement.textContent = result.error;
                    errorElement.style.display = 'block';
                } else {
                    stripe.confirmBankTransferPayment(result.clientSecret, {
                        payment_method: {
                            billing_details: {
                                name: '{{ auth()->user()->name }}',
                                email: '{{ auth()->user()->email }}',
                            },
                        },
                    }).then(function (result) {
                        if (result.error) {
                            var errorElement = document.getElementById('payment-message');
                            errorElement.textContent = result.error.message;
                            errorElement.style.display = 'block';
                        } else {
                            var successElement = document.getElementById('payment-message');
                            successElement.textContent = 'Payment successful! Please complete the bank transfer.';
                            successElement.style.display = 'block';
                        }
                    });
                }
            });
        });
        

        function updatePaymentMethod() {
            var paymentMethod = document.getElementById('payment_method').value;
            document.getElementById('selected_payment_method').innerText = paymentMethod;
            document.getElementById('confirmation_payment_method').value = paymentMethod;
        }

        function updateShippingAddress() {
            var shippingAddress = document.getElementById('shipping_address').value.split(' ');
            document.getElementById('selected_shipping_postcode').innerText = shippingAddress[0];
            document.getElementById('selected_shipping_address').innerText = shippingAddress[1];
            document.getElementById('selected_shipping_building').innerText = shippingAddress[2];
            document.getElementById('confirmation_shipping_address').value = shippingAddress.join(' ');
        }

        // 初期表示
        document.addEventListener('DOMContentLoaded', function() {
            updatePaymentMethod();
            updateShippingAddress();
        });

        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');
        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        document.getElementById('credit-card-button').addEventListener('click', function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // カード決済後の購入フォーム送信
            var purchaseForm = document.getElementById('purchase-form');
            document.getElementById('confirmation_payment_method').value = 'credit_card';
            purchaseForm.submit();
        }
    </script>
@endsection