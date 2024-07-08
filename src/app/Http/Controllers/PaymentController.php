<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Models\ShippingAddress;
use Stripe\Stripe;
use App\Http\Requests\PaymentRequest;
use Stripe\PaymentIntent;



class PaymentController extends Controller
{
    public function purchase(PaymentRequest $request, $item_id)
    {
        
        // ログインユーザーの取得
        $user_id = auth()->user()->id;

        // アイテムの取得
        $item = Item::findOrFail($item_id);

        // 住所変更テーブルのデータがあればそのIDを取得
        $shippingAddress = ShippingAddress::where('item_id', $item_id)->latest()->first();
        $shipping_Addresses_id = $shippingAddress ? $shippingAddress->id : null;

        // 支払い方法の取得
        $paymentMethod = $request->input('payment_method');

        if ($paymentMethod === 'credit_card') {
            // クレジットカード支払いの場合
            return response()->json([
                'client_select' => $item->price,
            ]);
        }

        // クレジットカード以外の支払い方法の処理
        if ($paymentMethod === 'convenience_store') {
            // コンビニ支払処理
        } elseif ($paymentMethod === 'bank_transfer') {

        }

    // 支払い情報の保存
    $payment = new Payment();
    $payment->item_id = $item_id;
    $payment->amount = $item->price; // ここではアイテムの価格を支払い金額とする
    $payment->method = $paymentMethod;
    $payment->status = 'completed'; // 支払いステータスを設定（例: 'completed'）
    $payment->save();

        // アイテムのステータス更新
        $item->sold_user_id = $user_id; 
        $item->save();

    // 処理が完了したらリダイレクトと成功メッセージの表示
    return redirect()->route('items.show', ['item_id' => $item_id])->with('success', '商品を購入しました！');
}

    public function show()
    {
        return view('payment');
    }

    public function createKonbiniPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // リクエストからアイテムのIDを取得し、アイテムを取得する
        $item = Item::findOrFail($request->item_id);

        // アイテムの価格を計算
        $amount = $item->price;
        $currency = 'jpy'; // 通貨を日本円に設定

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

    public function createBankTransferPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // リクエストからアイテムのIDを取得し、アイテムを取得する
        $item = Item::findOrFail($request->item_id);

        // アイテムの価格を取得
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

    public function charge(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // リクエストからアイテムのIDを取得し、アイテムを取得する
            $item = Item::findOrFail($request->item_id);

            // アイテムの価格をセント単位で計算
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
}
