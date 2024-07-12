document.addEventListener('DOMContentLoaded', function() {
    updatePaymentMethod();
    updateShippingAddress();
});

function updatePaymentMethod() {
    var paymentMethod = document.getElementById('payment_method').value;
    var paymentMethodName = '';

    switch(paymentMethod) {
        case 'credit_card':
            paymentMethodName = 'クレジットカード';
            break;
        case 'convenience_store':
            paymentMethodName = 'コンビニ';
            break;
        case 'bank_transfer':
            paymentMethodName = '銀行振込';
            break;
        default:
            paymentMethodName = '未選択';
            break;
    }

    document.getElementById('selected_payment_method').innerText = paymentMethodName;
    document.getElementById('confirmation_payment_method').value = paymentMethod;
}

function updateShippingAddress() {
    var shippingAddress = document.getElementById('shipping_address').value.split(' ');
    document.getElementById('selected_shipping_postcode').innerText = shippingAddress[0];
    document.getElementById('selected_shipping_address').innerText = shippingAddress[1];
    document.getElementById('selected_shipping_building').innerText = shippingAddress[2];
    document.getElementById('confirmation_shipping_address').value = shippingAddress.join(' ');
}

var stripe = Stripe(document.querySelector('meta[name="stripe-key"]').content);
var elements = stripe.elements();

var style = {
    base: {
        fontSize: '16px',
        color: '#32325d',
        padding: '10px 12px' // パディングを追加
    },
};

var cardNumberElement = elements.create('cardNumber', {
    style: style,
});
cardNumberElement.mount('#card-number-element');

var cardExpiryElement = elements.create('cardExpiry', {
    style: style,
});
cardExpiryElement.mount('#card-expiry-element');

var cardCvcElement = elements.create('cardCvc', {
    style: style,
});
cardCvcElement.mount('#card-cvc-element');

var postalCodeElement = elements.create('postalCode', {
    style: style,
});
postalCodeElement.mount('#postal-code-element');

var displayError = document.getElementById('card-errors');
cardNumberElement.on('change', function(event) {
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();
    stripe.createToken(cardNumberElement, {
        address_zip: postalCodeElement.value,
    }).then(function(result) {
        if (result.error) {
            displayError.textContent = result.error.message;
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

document.getElementById('konbini-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('purchase-form').submit();
});

document.getElementById('bank-transfer-button').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('purchase-form').submit();
});
