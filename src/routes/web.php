<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ログインユーザールート
Route::get('/', [ItemController::class, 'items']);

// ログイン画面表示
Route::get('/login', function () {
    return view('auth.login');
})->name('login');  // ここで 'login' という名前を付ける

// ログイン処理
Route::post('/login', [AuthController::class, 'login']);

// 会員登録画面表示
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// 会員登録処理
Route::post('/register', [AuthController::class, 'register']);

//　アイテム詳細ページ
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

//　トップページに戻る
Route::get('/', [ItemController::class, 'showItems'])->name('items.index');

//　検索用ルート
Route::get('items/search', [ItemController::class, 'search'])->name('items.search');

//　コメントページ表示
Route::get('/items/{item}/comment', [CommentController::class, 'showCommentForm'])->name('comments.show');

//　コメント投稿
Route::post('/items/{item}/comment', [CommentController::class, 'storeComment'])->name('comments.store')->middleware('auth');


//　ユーザー認証ミドルウェア
Route::middleware('auth')->group(function () {
    //　プロフィール画面表示
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    //　プロフィール新規作成・更新ページ
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    

    // アイテム作成フォームの表示
    Route::get('/items/create', [ItemController::class, 'showCreateForm'])->name('items.create_form');
    Route::post('/items/create', [ItemController::class, 'create'])->name('items.create');

    //　お気に入り登録/削除機能
    Route::post('/likes/{item_id}', [LikeController::class, 'like'])->name('likes.like');
    Route::delete('/likes/{item_id}', [LikeController::class, 'unlike'])->name('likes.unlike');

    //　マイページの表示
    Route::get('/mypage', [likeController::class, 'mypage'])->name('mypage');
    //Route::get('/likes', [LikeController::class, 'index'])->name('likes.index');
    Route::get('/item/{id}', [ItemController::class, 'show'])->name('items.show');



    // 購入手続きページの表示
    Route::post('/items/{item_id}/buy', [ItemController::class, 'showBuyForm'])->name('items.buy');

    // 支払い方法変更ページの表示
    Route::put('/payment/{item_id}/update', [PaymentController::class, 'update'])->name('payment.update');

    // 配送先変更ページの表示
    Route::put('/shipping/{item_id}/update', [ShippingController::class, 'update'])->name('shipping.update');

    // 購入完了ページの表示
    Route::post('/purchase/complete/{item_id}', [PurchaseController::class, 'complete'])->name('purchase.complete');
});