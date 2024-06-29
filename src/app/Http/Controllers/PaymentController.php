<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Models\ShippingChange;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Charge;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function purchase(PaymentRequest $request, $item_id)
    {
        // ログインユーザーの取得
        $user_id = auth()->user()->id;

        // アイテムの取得
        $item = Item::findOrFail($item_id);

        // 住所変更テーブルのデータがあればそのIDを取得
        $shippingChange = ShippingChange::where('user_id', $user_id)->latest()->first();
        $shipping_changes_id = $shippingChange ? $shippingChange->id : null;

        // 支払い情報の保存
        $payment = new Payment();
        $payment->user_id = $user_id;
        $payment->item_id = $item_id;
        $payment->amount = $item->price;
        $payment->method = $request->input('payment_method');
        $payment->status = 'completed'; // 支払いステータスを設定
        $payment->shipping_changes_id = $shipping_changes_id;
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
                'amount' => $amount, // 金額を適切に設定
                'currency' => $currency,
                'payment_method_types' => ['jp_bank_transfer'],
            ]);

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function bankTransferReturn(Request $request)
    {
        // 銀行振込完了後の処理をここに記述
        return view('payment-success');
    }

    public function charge(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // リクエストからアイテムのIDを取得し、アイテムを取得する
            $item = Item::findOrFail($request->item_id);

            // アイテムの価格をセント単位で計算
            $amount = $item->price;

            \Stripe\Charge::create([
                "amount" => $amount,
                "currency" => "jpy",
                "source" => $request->stripeToken,
                "description" => "購入処理: " . $item->name
            ]);

            return back()->with('success_message', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->with('error_message', 'Error: ' . $e->getMessage());
        }
    }
}
