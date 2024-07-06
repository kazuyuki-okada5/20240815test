<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;

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

    //　マイページ表示用のメゾット
    public function showMypage()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        
        return view('auth.maypage' , compact('user', 'profile'));
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

    public function update(ProfileRequest $request)
    {
        $userId = Auth::id();
        $profile = Profile::where('user_id', $userId)->firstOrFail();

        //　ユーザー名を更新
        $user = User::findOrFail($userId); //　ユーザーテーブルからユーザー情報を取得
        $user->name = $request->name; //　フォームからの入力でユーザー名を更新
        $user->save(); //　ユーザー情報を保存

        //　画像がアップロードされている場合の処理
        if($request->hasFile('img_url')) {
            //　古い画像のパス取得
            $oldImagePath = $profile->img_url;

            $file = $request->file('img_url');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profiles', $filename);
            $newImagePath = 'profiles/' . $filename;
            $profile->img_url = $newImagePath;

            $profile->save();

            //　古いファイルを削除
            if ($oldImagePath) {
                Storage::delete('public/' . $oldImagePath);
            }

        }

        // フォームからの入力を更新
        $profile->post_code = $request->post_code;
        $profile->address = $request->address;
        $profile->building = $request->building;
        $profile->save();

        //　プロフィール更新後にプロフィール詳細ページにリダイレクトし、成功メッセージを表示
        return redirect()->route('profile.show')->with('success', 'プロフィールが更新されました');

    }

        // プロフィールを新規作成するフォームを表示するメソッド
    public function create()
    {
        return view('profiles.create');
    }

    // プロフィールを新規作成するメソッド
    public function store(ProfileRequest $request)
{
    // リクエストからデータを受け取り、新しいプロフィールを作成する
    $profile = new Profile();
    $profile->user_id = Auth::id();
    $profile->post_code = $request->post_code;
    $profile->address = $request->address;
    $profile->building = $request->building;

    // ユーザー名の更新
    $user = Auth::user();
    $user->name = $request->name;
    $user->save();

    // 画像がアップロードされている場合の処理
    if ($request->hasFile('img_url')) {
        $imagePath = $request->file('img_url')->store('profiles', 'public');
        $profile->img_url = $imagePath;
    }

    // プロフィールを保存する
    $profile->save();

    // プロフィール作成後にリダイレクトするなどの処理を行う
    return redirect()->route('profile.show')->with('success', 'プロフィールが作成されました');
}

}
