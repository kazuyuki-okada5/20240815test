<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Payment;
use Stripe\Stripe;
use App\Http\Requests\PaymentRequest;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    // 決済処理
    public function purchase(PaymentRequest $request, $itemId)
    {
        $userId = auth()->user()->id;
        $item = Item::findOrFail($itemId);
        $paymentMethod = $request->input('payment_method');

        Stripe::setApiKey(config('services.stripe.secret'));
        if ($paymentMethod === 'credit_card') {
            $item = Item::findOrFail($request->item_id);
            $amount = $item->price;
            \Stripe\Charge::create([
                "amount" => $amount,
                "currency" => "jpy",
                "source" => $request->stripeToken,
                "description" => "Test payment"
            ]);
        } elseif ($paymentMethod === 'convenience_store') {
        } elseif ($paymentMethod === 'bank_transfer') {
        }

        $payment = new Payment();
        $payment->item_id = $itemId;
        $payment->amount = $item->price;
        $payment->method = $paymentMethod;
        $payment->status = 'completed';
        $payment->save();
        $item->sold_user_id = $userId;
        $item->save();

        return redirect()->route('items.show', ['item_id' => $itemId])->with('success', '商品を購入しました！');
    }
    
    // カードstripe決済
    public function charge(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $item = Item::findOrFail($request->item_id);
            $amount = $item->price;
            \Stripe\Charge::create([
                "amount" => $amount,
                "currency" => "jpy",
                "source" => $request->stripeToken,
                "description" => "Test payment"
            ]);

            return back()->with('success_message', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->with('error_message', 'Error: ' . $e->getMessage());
        }
    }

    // コンビニstripe決済
    public function createKonbiniPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $item = Item::findOrFail($request->item_id);
        $amount = $item->price;
        $currency = 'jpy';
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method_types' => ['konbini'],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 銀行振込stripe決済
    public function createBankTransferPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $item = Item::findOrFail($request->item_id);
        $amount = $item->price;
        $currency = 'jpy';

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method_types' => ['jp_bank_transfer'],
            ]);
            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
