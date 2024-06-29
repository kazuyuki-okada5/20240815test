<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use App\Models\ShippingChange;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShippingChangeRequest;
use Illuminate\Support\Facades\DB;  // ← これを追加します

class ShippingController extends Controller
{
    // 配送先変更フォームの表示
    public function edit($item_id)
    {
        $user = Auth::user();
        
        // ユーザーのプロフィール情報を取得
        $profile = Profile::where('user_id', $user->id)->first();

        // ユーザーの登録した配送先情報を取得
        $shippingChanges = ShippingChange::where('item_id', $item_id)->get();

        // アイテム情報を取得
        $item = Item::findOrFail($item_id);

        return view('items.shipping_change', compact('profile', 'shippingChanges', 'item'));
    }

    // 配送先情報の更新処理
 // 配送先情報の更新処理
    public function update(Request $request, $item_id)
    {
        // アイテム情報を取得
        $item = Item::findOrFail($item_id);

        // 同じ住所と郵便番号が既に存在するか確認
        $existingShipping = ShippingChange::where('item_id', $item->id)
                                          ->where('address', $request->address)
                                          ->where('post_code', $request->post_code)
                                          ->first();

        if ($existingShipping) {
            return redirect()->back()->withErrors(['address' => 'この配送先は既に登録されています。']);
        }

        // 新しい配送先情報を作成
        $shippingChange = new ShippingChange([
            'item_id' => $item->id,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        $shippingChange->save();

        return redirect()->route('items.buy', $item_id)->with('success', '配送先を追加しました。');
    }
}