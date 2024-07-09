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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
// トップページ
Route::get('/', [ItemController::class, 'showItems'])->name('items.index');

// 会員登録画面表示
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// 会員登録処理
Route::post('/register', [AuthController::class, 'register']);

// ログイン画面表示
Route::get('/login', function () {
    return view('auth.login');
})->name('login');  // ここで 'login' という名前を付ける

// ログイン処理
Route::post('/login', [AuthController::class, 'login']);

//　商品詳細ページ
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

//　検索用ルート
Route::get('items/search', [ItemController::class, 'search'])->name('items.search');

//　コメントページ表示
Route::get('/items/{item}/comment', [CommentController::class, 'showCommentForm'])->name('comments.show');

//　ユーザー認証ミドルウェア
Route::middleware('auth')->group(function () {
    //　プロフィール画面表示
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    //　プロフィール新規作成・更新ページ
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    //　コメント投稿
    Route::post('/items/{item}/comment', [CommentController::class, 'storeComment'])->name('comments.store')->middleware('auth');

    // アイテム作成フォームの表示
    Route::get('/items/create', [ItemController::class, 'showCreateForm'])->name('items.create_form');
    Route::post('/items/create', [ItemController::class, 'create'])->name('items.create');

    //　お気に入り登録/削除機能
    Route::post('/likes/{item_id}', [LikeController::class, 'like'])->name('likes.like');
    Route::delete('/likes/{item_id}', [LikeController::class, 'unlike'])->name('likes.unlike');

    //　マイページの表示
    Route::get('/mypage', [LikeController::class, 'mypage'])->name('mypage');

    // 購入手続きフォームの表示と購入処理
    Route::get('/items/{item_id}/buy', [ItemController::class, 'showBuyForm'])->name('items.buy');

    // 支払い方法変更ページの表示
    Route::get('/payment/{item_id}/update', [PaymentController::class, 'showUpdateForm'])->name('payment.update.show');
    Route::put('/payment/{item_id}/update', [PaymentController::class, 'update'])->name('payment.update');

    // 配送先変更ページの表示
    Route::get('/items/{item_id}/shipping/address', [ShippingController::class, 'edit'])->name('shipping.address.show');
    Route::put('/items/{item_id}/update-shipping', [ShippingController::class, 'update'])->name('shipping.update');

    // 支払い方法変更
    Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'show']);
    Route::post('/charge', [App\Http\Controllers\PaymentController::class, 'charge'])->name('charge');
    Route::post('/create-konbini-payment-intent', [PaymentController::class, 'createKonbiniPaymentIntent'])->name('create.konbini.payment.intent');
    Route::post('/bank-transfer/payment-intent', [PaymentController::class, 'createBankTransferPaymentIntent'])->name('create.bank.transfer.payment.intent');

    Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

     // 購入完了ページの表示
    Route::post('/items/{item_id}/purchase', [PaymentController::class, 'purchase'])->name('items.purchase');   
});

// 管理者のみアクセス可能なルート
Route::middleware(['auth', 'checkrole:0'])->group(function() {
    Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('admin.users');
    Route::delete('admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    // コメント削除用のルート
    Route::delete('/admin/comments/{comment}', [AdminController::class, 'deleteComment'])->name('admin.comments.delete');
    // 管理者メール送信
    Route::post('/admin/users/send-email', [AdminController::class, 'sendEmail'])->name('admin.users.sendEmail');
});


// Route::get('/bank-transfer-return', [PaymentController::class, 'bankTransferReturn'])->name('bank.transfer.return');
// Route::post('/confirm/konbini/payment', [PaymentController::class, 'confirmKonbiniPayment'])->name('confirm.konbini.payment');


// Route::get('/send-test-mail', [AdminController::class, 'sendTestMail']);



Route::post('/webhook/stripe', function (Request $request) {
    // StripeのWebhookシークレットを取得
    $webhookSecret = env('STRIPE_WEBHOOK_SECRET');
    
    $signature = $request->header('Stripe-Signature');
    $payload = $request->getContent();

    try {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $event = \Stripe\Webhook::constructEvent(
            $payload, $signature, $webhookSecret
        );

        // イベントの種類に応じて処理
        if ($event->type == 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            // 支払い成功時の処理
            Log::info('Payment Intent Succeeded: ' . $paymentIntent->id);
        } elseif ($event->type == 'payment_intent.payment_failed') {
            $paymentIntent = $event->data->object;
            // 支払い失敗時の処理
            Log::error('Payment Intent Failed: ' . $paymentIntent->id);
        }

        return response()->json(['status' => 'success']);
    } catch (\UnexpectedValueException $e) {
        // 無効なペイロード
        return response()->json(['status' => 'invalid payload'], 400);
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
        // 無効な署名
        return response()->json(['status' => 'invalid signature'], 400);
    }
});
