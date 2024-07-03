<!DOCTYPE html>
<html>
<head>
    <title>Laravel Stripe Payment</title>
    <!-- BootstrapのCSSをインクルード -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <!-- 成功メッセージの表示 -->
    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif
    <!-- エラーメッセージの表示 -->
    @if (session('error_message'))
        <div class="alert alert-danger">
            {{ session('error_message') }}
        </div>
    @endif

    <!-- クレジットカード支払いフォーム -->
    <form action="{{ route('charge') }}" method="post" id="payment-form">
        @csrf <!-- CSRFトークンの挿入 -->
        <div id="card-element">
            <!-- Stripe Elementがここに挿入されます -->
        </div>
        <button class="btn btn-primary mt-3">支払いを送信</button>
    </form>
    
    <!-- コンビニ支払いボタン -->
    <button id="konbini-button" class="btn btn-primary mt-3">コンビニで支払う</button>
    <!-- 銀行振込支払いボタン -->
    <button id="bank-transfer-button" class="btn btn-primary mt-3">銀行振込で支払う</button>

    <!-- 支払いメッセージの表示 -->
    <div id="payment-message" class="alert alert-info" style="display: none;"></div>
</div>

<!-- StripeのJavaScriptライブラリ -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}'); // Stripeオブジェクトを作成

    // コンビニ支払いボタンのクリックイベント
    document.getElementById('konbini-button').addEventListener('click', function () {
        fetch('{{ route('create.konbini.payment.intent') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRFトークンのヘッダー
            }
        })
        .then(function (response) {
            return response.json(); // JSON形式でレスポンスをパース
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
                        successElement.textContent = '支払いが成功しました！コンビニでの支払いを完了してください。';
                        successElement.style.display = 'block';
                    }
                });
            }
        });
    });

    // 銀行振込支払いボタンのクリックイベント
    document.getElementById('bank-transfer-button').addEventListener('click', function () {
        fetch('{{ route('create.bank.transfer.payment.intent') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRFトークンのヘッダー
            }
        })
        .then(function (response) {
            return response.json(); // JSON形式でレスポンスをパース
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
                        successElement.textContent = '支払いが成功しました！銀行振込を完了してください。';
                        successElement.style.display = 'block';
                    }
                });
            }
        });
    });
</script>

<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}'); // Stripeオブジェクトを作成
    var elements = stripe.elements(); // Stripe Elementsを作成
    var card = elements.create('card'); // カード要素を作成
    card.mount('#card-element'); // カード要素を#card-elementに挿入

    // カード情報の変更イベント
    card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // フォームの送信イベント
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // フォームのデフォルト送信を防止

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token); // トークン処理ハンドラを呼び出し
            }
        });
    });

    // トークン処理ハンドラ
    function stripeTokenHandler(token) {
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        form.submit(); // フォームを送信
    }
</script>
</body>
</html>

