<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;

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
Route::get('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);

//　アイテム詳細ページ
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');
//　トップページに戻る
Route::get('/', [ItemController::class, 'items'])->name('items.index');

//　検索用ルート
Route::get('items/search', [ItemController::class, 'search'])->name('items.search');

//　プロフィール画面表示ページ(ユーザー認証ミドルウェア後表示)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update'); // PUT メソッドを使用する
    // アイテム作成フォームの表示
    Route::get('/items/create', [ItemController::class, 'showCreateForm'])->name('items.create_form');
    Route::post('/items/create', [ItemController::class, 'create'])->name('items.create');

    //　お気に入り登録/削除機能
    Route::post('/items/{item}/like', [LikeController::class, 'like'])->name('likes.like');
    Route::post('/items/{item}/unlike', [LikeController::class, 'unlike'])->name('likes.unlike');

    //　お気に入りページの表示
    Route::get('/likes', [LikeController::class, 'index'])->name('likes.index');
    Route::get('/item/{id}', [ItemController::class, 'show'])->name('items.show');

    //　出品商品一覧ページ
    //Route::get('/items/selling', [ItemController::class, 'selling'])->name('items.selling');
    //　購入商品一覧ページ
    //Route::get('/items/purchased', [ItemController::class, 'purchased'])->name('items.purchased');
    //　マイページの表示
    Route::get('/mypage', [likeController::class, 'mypage'])->name('mypage');
});