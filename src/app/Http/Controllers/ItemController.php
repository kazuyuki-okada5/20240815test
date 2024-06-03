<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function items()
    {
        // Itemテーブルから画像と価格だけ取得
        $items = Item::select('id', 'image_url', 'price')->get();

        //　items.itemビューを表示し、$items変数を渡す
        return view('items.item', ['items' => $items]);
    }

    public function show($item_id)
    {
        // IDでアイテムを取得
        $item = Item::findOrFail($item_id);
        // IDでアイテムを出品したユーザーのnameを取得する
        $user = User::findOrFail($item->user_id)->name;

        // items.detailビューを表示し、$item変数を渡す
        return view('items.detail', ['item' => $item, 'user' => $user]);
    }
}
