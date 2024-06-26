<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Models\ShippingChange;

class PaymentController extends Controller
{
    public function purchase(Request $request, $item_id)
    {
        // バリデーション
        $request->validate([
            'payment_method' => 'required|string',
            'shipping_address' => 'required|string',
        ]);

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
    $payment->amount = $item->price; // ここではアイテムの価格を支払い金額とする
    $payment->method = $request->input('payment_method');
    $payment->status = 'completed'; // 支払いステータスを設定（例: 'completed'）
    $payment->shipping_changes_id = $shipping_changes_id; // 住所変更テーブルのIDを設定する
    $payment->save();

        // アイテムのステータス更新
        $item->sold_user_id = $user_id; 
        $item->save();

    // 処理が完了したらリダイレクトと成功メッセージの表示
    return redirect()->route('items.show', ['item_id' => $item_id])->with('success', '商品を購入しました！');
}
}
