<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Profile;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShippingAddressRequest;

class ShippingController extends Controller
{
    // 配送先変更フォームの表示
    public function edit($item_id)
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $item = Item::findOrFail($item_id);
        $shippingAddresses = ShippingAddress::where('item_id', $item_id)->get();

        return view('items.shipping_address', compact('profile', 'shippingAddresses', 'item'));
    }

    // 配送先情報の更新処理
    public function update(ShippingAddressRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // バリデーションは ShippingAddressRequest で行われるため、ここでは必要ない
        if (ShippingAddress::where([
            ['item_id', $item->id],
            ['address', $request->address],
            ['post_code', $request->post_code],
        ])->exists()) {
            return redirect()->back()->withErrors(['address' => 'この配送先は既に登録されています。']);
        }

        ShippingAddress::create([
            'item_id' => $item->id,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('items.buy', $item_id)->with('success', '配送先を追加しました。');
    }
}

