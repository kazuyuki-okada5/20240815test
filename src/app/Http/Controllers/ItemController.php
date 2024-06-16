<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Like;
use App\Models\Category;
use App\Models\Condition;
use App\Models\CategoryItem;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ItemCreateRequest;
use Illuminate\Validation\ValidationException;

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
    public function showCreateForm()
    {
        $conditions = Condition::all();
        $categories = Category::all();

        return view('items.create', compact('conditions', 'categories'));
    }

    //　出品処理
    public function create(ItemCreateRequest $request)
{
    $input = $request->validated();
    $userId = Auth::id();

    $condition = Condition::where('condition', $input['condition'])->first();

    if (!$condition) {
        return back()->withInput()->withErrors(['error' => '選択された条件が無効です']);
    }

    // カテゴリーの選択を確認
    $categories = array_filter([
        $input['category1'],
        $input['category2'] ?? null,
        $input['category3'] ?? null,
    ]);

    if (empty($categories)) {
        return back()->withInput()->withErrors(['error' => '少なくとも1つのカテゴリーを選択してください。']);
    }

    // カテゴリーの重複チェック
    if ($this->hasDuplicateCategories($categories)) {
        return back()->withInput()->withErrors(['error' => 'カテゴリーは重複して選択できません。']);
    }

    $imagePath = null;
    if ($request->hasFile('image_url')) {
        $imagePath = $request->file('image_url')->store('images', 'public');
    } elseif ($request->session()->has('image_url')) {
        $imagePath = $request->session()->get('image_url');
    }

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

    foreach ($categories as $category) {
        CategoryItem::create([
            'item_id' => $item->id,
            'category_id' => $category,
        ]);
    }

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
    public function showBuyForm($item_id)
    {
        $item = Item::findOrFail($item_id);
        return view('items.buy', compact('item'));
    }
}
