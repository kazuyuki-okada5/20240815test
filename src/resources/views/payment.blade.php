<!DOCTYPE html>
<html>
<head>
    <title>Laravel Stripe Payment</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
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
            <div id="card-element">
                <!-- A Stripe Element will be inserted here. -->
            </div>
        </div>
        <button class="btn btn-primary mt-3">Submit Payment</button>
    </form>
    <button id="konbini-button" class="btn btn-primary mt-3">Pay with Konbini</button>
    <button id="bank-transfer-button" class="btn btn-primary mt-3">Pay with Bank Transfer</button>

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
            }
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
            }
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
                        successElement.textContent = 'Payment successful! Please complete the bank transfer.';
                        successElement.style.display = 'block';
                    }
                });
            }
        });
    });
</script>

<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
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

    function stripeTokenHandler(token) {
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        form.submit();
    }
</script>
</body>
</html>

