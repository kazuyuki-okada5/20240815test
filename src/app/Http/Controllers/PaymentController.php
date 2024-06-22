<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function update(Request $request, $item_id)
    {
        // 支払い方法の更新処理をここに追加
        return view('items.shipping_change', ['item_id' => $item_id]);
    }
}
