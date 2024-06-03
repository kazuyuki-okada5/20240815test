<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //　プロフィール表示用のメゾット
    public function show()
    {
        //　ログイン中ユーザーIDを取得
        $userId = Auth::id();

        //　ログイン中のユーザープロフイールを取得
        $profile = Profile::where('user_id', $userId)->firstOrFail();

        //　ビューにデータを渡して表示
        return view('profiles.show', ['profile' => $profile]);
    }

    // プロフィール編集表示用のメゾット
    public function edit()
    {
        // ログイン中ユーザーIDを取得
        $userId = Auth::id();

        //　ログイン中のユーザープロフィールを取得
        $profile = Profile::where('user_id', $userId)->firstOrFail();

        //　ビューにデータを渡して表示
        return view('profiles.edit', ['profile' => $profile]);
    }

    public function update(Request $request)
    {
        $userId = Auth::id();
        $profile = Profile::where('user_id', $userId)->firstOrFail();

        //　ユーザー名を更新
        $user = User::findOrFail($userId); //　ユーザーテーブルからユーザー情報を取得
        $user->name = $request->name; //　フォームからの入力でユーザー名を更新
        $user->save(); //　ユーザー情報を保存

        // フォームからの入力を更新
        $profile->update([
            'img_url' => $request->img_url,
            'post_code' => $request -> post_code,
            'address' => $request -> address,
            'building' => $request -> building,
        ]);

        //　プロフィール更新後にプロフィール詳細ページにリダイレクトし、成功メッセージを表示
        return redirect()->route('profile.show')->with('success', 'プロフィールが更新されました');

    }

}