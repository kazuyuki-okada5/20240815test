<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use App\Models\ShippingChange;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    // 配送先変更フォームの表示
    public function edit($item_id)
    {
        $user = Auth::user();
        
        // ユーザーのプロフィール情報を取得
        $profile = Profile::where('user_id', $user->id)->first();

        // ユーザーの登録した配送先情報を取得
        $shippingChanges = ShippingChange::where('user_id', $user->id)->get();

        // アイテム情報を取得
        $item = Item::findOrFail($item_id);

        return view('items.shipping_change', compact('profile', 'shippingChanges', 'item'));
    }

    // 配送先情報の更新処理
public function update(Request $request, $item_id)
{
    $request->validate([
        'post_code' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'building' => 'nullable|string|max:255',
    ]);

    $user = Auth::user();

    // 同じ住所が既に存在するか確認
    $existingShipping = ShippingChange::where('user_id', $user->id)
                                      ->where('address', $request->address)
                                      ->first();

    if ($existingShipping) {
        // 既に同じ住所が存在する場合の処理
        // 適切なエラーメッセージを設定してリダイレクトするなど
        return redirect()->back()->withErrors(['address' => 'この住所は既に登録されています。']);
    }

    // 新しい配送先情報を作成
    $shippingChange = new ShippingChange([
        'user_id' => $user->id,
        'item_id' => $item_id, // ここで item_id を設定する
        'post_code' => $request->post_code,
        'address' => $request->address,
        'building' => $request->building,
    ]);
    $shippingChange->save();

    return redirect()->route('items.buy', $item_id)->with('success', '配送先を追加しました。');
}

}
