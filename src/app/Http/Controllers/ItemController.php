<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemCreateRequest;
use App\Models\ShippingChange;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Condition;
use App\Models\CategoryItem;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ItemController extends Controller
{
    public function showItems()
    {
        $items = Item::all(); // すべてのアイテムを取得

        $likes = collect(); // 空のコレクションを初期化
        if (Auth::check()) {
            $user = Auth::user();
            $likes = Like::where('user_id', $user->id)->with('item')->get(); // ユーザーのお気に入り
        }

        return view('items.item', compact('items', 'likes'));
    }

    public function mypage()
    {
        $items = Item::all();

        if(Auth::check()) {
            $user =Auth::user();
            $items = Item::all(); // すべてのアイテム
            $likes = Like::where('user_id', $user->id)->get();
            return view('auth.mypage', compact('user', 'items', 'likes'));
        }else{
            return view('auth.mypage', compact('items'));
        }
    }

    //　アイテム名を検索
    public function search(Request $request)
    {
        $query = $request->input('query');
        $items = Item::where('name', 'like', '%' . $query . '%')->get();

        return view('items.search_results', ['items' => $items]);
    }

    public function show($item_id)
    {
        // IDでアイテムを取得
        $item = Item::with('categories', 'condition')->findOrFail($item_id);
        // IDでアイテムを出品したユーザーのnameを取得する
        $user = User::findOrFail($item->user_id)->name;
        //　現在のユーザーがこのアイテムをお気に入りにしているかをチェック
        $isLiked = Auth::check() && Auth::user()->likes()->where('item_id', $item->id)->exists();
        //　ユーザーが何人お気に入りしているかカウント
        $likeCount = Like::where('item_id', $item_id)->count();
        //　コメント数をカウント
        $commentCount = Comment::where('item_id',$item_id)->count();

        // items.detailビューを表示し、$item変数を渡す
        return view('items.detail', ['item' => $item, 'user' => $user, 'isLiked' => $isLiked, 'likeCount' => $likeCount, 'commentCount' => $commentCount ]);
    }

    //　出品ページの表示
public function showCreateForm(Request $request)
{
    $categories = Category::all();
    $conditions = Condition::all();
    $imageUrl = $request->session()->get('image_url', null);

    return view('items.create', compact('categories', 'conditions', 'imageUrl'));
}

public function create(ItemCreateRequest $request)
{
    $input = $request->validated();
    $userId = Auth::id();

    $condition = Condition::where('condition', $input['condition'])->first();

    if (!$condition) {
        return back()->withInput()->withErrors(['error' => '選択された条件が無効です']);
    }

    if ($this->hasDuplicateCategories($input['categories'])) {
        return back()->withInput()->withErrors(['error' => '同じカテゴリーを複数選択することはできません。']);
    }

    $imagePath = $request->session()->get('image_url');
    if ($request->hasFile('image_url')) {
        $imagePath = $request->file('image_url')->store('images', 'public');
        $request->session()->put('image_url', $imagePath);
    }

    DB::transaction(function () use ($input, $userId, $condition, $imagePath) {
        $item = new Item([
            'user_id' => $userId,
            'name' => $input['name'],
            'price' => $input['price'],
            'comment' => $input['comment'],
            'image_url' => $imagePath,
            'brand' => $input['brand'] ?? null,
            'condition_id' => $condition->id,
        ]);

        $item->save();

        foreach ($input['categories'] as $category) {
            CategoryItem::create([
                'item_id' => $item->id,
                'category_id' => $category,
            ]);
        }
    });

    $request->session()->forget('image_url');
    return redirect()->route('items.create')->with('success', 'アイテムが追加されました！');
}


// カテゴリーの重複チェックメソッド
private function hasDuplicateCategories($categories)
{
    return count($categories) !== count(array_unique($categories));
}

    //　出品商品一覧ページを処理するメソッド
    public function selling()
    {
        $user = Auth::user();
        $items = Item::where('user_id', $user->id)->get();

        return view('items.selling', ['items' => $items]);
    }

    //　購入商品一覧ページを処理するメソッド
    public function purchased()
    {
        $user = Auth::user();
        $items = Item::where('sold_user_id', $user->id)->get();

        return view('items.purchased', ['items' => $items]);
    }

    //　購入手続きページを処理するメソッド
public function showBuyForm($id)
{
    // アイテムを取得します
    $item = Item::findOrFail($id);

    // 売り切れている場合の処理
    if ($item->sold_user_id !== null) {
        return back()->with('error', 'URL上から移動しようとした商品は売り切れのため、購入フォームは表示できません。');
    }

    // ユーザー情報を取得します
    $user = auth()->user();

    // ユーザーがプロフィール情報を持っているか確認
    if ($user->profile) {
        $profile = [
            'post_code' => $user->profile->post_code,
            'address' => $user->profile->address,
            'building' => $user->profile->building
        ];
    } else {
        // プロフィール情報が存在しない場合の処理
        $profile = [
            'post_code' => '',
            'address' => '',
            'building' => ''
        ];
    }


    // `shipping_changes`テーブルからユーザーの追加した配送先を取得
    $shippingChanges = ShippingChange::where('item_id', $item->id)->get();
    

    return view('items.buy', compact('item', 'profile', 'shippingChanges'));
}

    public function showAddress($item_id)
    {
        $item = Item::find($item_id);
        $user = auth()->user();
        $profile = $user->profile;
        $shippingChanges = ShippingChange::where('item_id', $item->id)->get();

        return view('items.buy', [
            'item' => $item,
            'profile' => $profile,
            'shippingChanges' => $shippingChanges,
        ]);
    }
    public function showShippingChangeForm($item_id)
{
    $item = Item::findOrFail($item_id);
    $user = auth()->user();
    $shipping = new ShippingChange(); // 新しいShippingChangeモデルを作成

    return view('items.shipping_change', compact('item', 'shipping'));
}

// public function buy(PaymentRequest $request, $item_id)
// {


//     // 支払い方法と配送先をセッションやDBに保存する処理
//     $paymentMethod = $request->input('payment_method');
//     $shippingAddress = $request->input('shipping_address');

//     // 支払い方法に応じた処理
//     if ($paymentMethod === 'credit_card') {
//         // クレジットカードの処理
//         // Stripe決済処理の追加
//         $this->processCreditCardPayment($item, $user);
//     } elseif ($paymentMethod === 'convenience_store') {
//         // コンビニ決済処理
//         $this->processConvenienceStorePayment($item, $user);
//     } elseif ($paymentMethod === 'bank_transfer'){
//         // 銀行振込処理
//         $this->processBankTransfer($item, $user);
//     }

//     // 購入処理後のリダイレクト
//     return redirect()->route('items.index')->with('success', '購入が完了しました。');
// }
}