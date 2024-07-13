<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Payment;
// use App\Models\ShippingAddress;
use Stripe\Stripe;
use App\Http\Requests\PaymentRequest;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{
    // 決済処理
    public function purchase(PaymentRequest $request, $itemId)
    {

        $userId = auth()->user()->id;

        $item = Item::findOrFail($itemId);

        // 支払い方法の取得
        $paymentMethod = $request->input('payment_method');

        Stripe::setApiKey(config('services.stripe.secret'));
        Log::info('エラーログ');
        if ($paymentMethod === 'credit_card') {
            // クレジットカード支払いの場合
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
        } elseif ($paymentMethod === 'convenience_store') {
            // コンビニ支払いの場合
        } elseif ($paymentMethod === 'bank_transfer') {
            // 銀行支払いの場合
        }

        // 支払い情報の保存
        $payment = new Payment();
        $payment->item_id = $itemId;
        $payment->amount = $item->price; // ここではアイテムの価格を支払い金額とする
        $payment->method = $paymentMethod;
        $payment->status = 'completed'; // 支払いステータスを設定（例: 'completed'）
        $payment->save();

        // アイテムのステータス更新
        $item->sold_user_id = $userId;
        $item->save();

        // 処理が完了したらリダイレクトと成功メッセージの表示
        return redirect()->route('items.show', ['item_id' => $itemId])->with('success', '商品を購入しました！');
    }
    
    // カードstripe決済
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

    // コンビニstripe決済
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

    // 銀行振込stripe決済
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


}
