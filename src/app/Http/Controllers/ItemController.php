<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemCreateRequest;
use App\Models\ShippingAddress;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;
use App\Models\Category;
use App\Models\Condition;
use App\Models\CategoryItem;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    // 認証が必要なメソッドにミドルウェアを適用
    public function __construct()
    {
        $this->middleware('auth')->only(['showBuyForm', 'selling', 'purchased']);
    }

    // 商品一覧ページ表示_(トップページ）
    public function showItems()
    {
        $items = Item::all();
        $likes = collect();
        if (Auth::check()) {
            $user = Auth::user();
            $likes = Like::where('user_id', $user->id)->with('item')->get();
        }

        return view('items.item', compact('items', 'likes'));
    }

    // アイテム名を検索
    public function search(Request $request)
    {
        $query = $request->input('query');
        $items = Item::where('name', 'like', '%' . $query . '%')->get();

        return view('items.search_results', ['items' => $items]);
    }

    // 商品詳細ページ表示
    public function show($item_id)
    {
        // IDでアイテムを取得
        $item = Item::with('categories', 'condition')->findOrFail($item_id);
        // IDでアイテムを出品したユーザーのnameを取得する
        $user = User::findOrFail($item->user_id)->name;
        // ユーザーがこのアイテムをお気に入りにしているかをチェック
        $isLiked = Auth::check() && Auth::user()->likes()->where('item_id', $item->id)->exists();
        // 何人のユーザーがお気に入りしているかカウント
        $likeCount = Like::where('item_id', $item_id)->count();
        // コメント数をカウント
        $commentCount = Comment::where('item_id', $item_id)->count();
        // items.detailビューを表示し、$item変数を渡す
        return view('items.detail', ['item' => $item, 'user' => $user, 'isLiked' => $isLiked, 'likeCount' => $likeCount, 'commentCount' => $commentCount]);
    }

    // 出品ページの表示
    public function showCreateForm(Request $request)
    {
        if (Auth::check()) {
            $categories = Category::all();
            $conditions = Condition::all();
            $imageUrl = $request->session()->get('image_url', null);
            return view('items.create', compact('categories', 'conditions', 'imageUrl'));
        } else {
            return redirect()->route('login')->with('error', 'ログインが必要です。');
        }
    }


    public function create(ItemCreateRequest $request)
    {
        $input = $request->validated();
        $userId = Auth::id();

        // 条件のチェック
        $condition = Condition::where('condition', $input['condition'])->firstOrFail();

        if (!$condition) {
            return back()->withInput()->withErrors(['error' => '選択された条件が無効です']);
        }

        if ($this->hasDuplicateCategories($input['categories'])) {
            return back()->withInput()->withErrors(['error' => '同じカテゴリーを複数選択することはできません。']);
        }

        // 画像の処理
        $imagePath = $request->session()->get('image_url');
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('images', 'public');
            $request->session()->put('image_url', $imagePath);
        }

        // アイテム登録中にエラーが発生した場合ロールバック
        DB::transaction(function () use ($input, $userId, $condition, $imagePath) {
            $item = Item::create([
                'user_id' => $userId,
                'name' => $input['name'],
                'price' => $input['price'],
                'comment' => $input['comment'],
                'image_url' => $imagePath,
                'brand' => $input['brand'] ?? null,
                'condition_id' => $condition->id,
            ]);

            // カテゴリーの関連付け
            $item->categories()->attach($input['categories']);
        });

        $request->session()->forget('image_url');
        return redirect()->route('items.create')->with('success', 'アイテムが追加されました！');
    }

    // カテゴリーの重複チェックメソッド
    private function hasDuplicateCategories($categories)
    {
        return count($categories) !== count(array_unique($categories));
    }

    // 購入手続きを処理
    public function showBuyForm($id)
    {
        // アイテムを取得します
        $item = Item::findOrFail($id);

        // 売り切れている場合の処理
        if ($item->sold_user_id !== null) {
            return back()->with('error', 'URL上から移動しようとした商品は売り切れです。');
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
        $shippingAddresses = ShippingAddress::where('item_id', $item->id)->get();

        return view('items.buy', compact('item', 'profile', 'shippingAddresses'));
    }
}
