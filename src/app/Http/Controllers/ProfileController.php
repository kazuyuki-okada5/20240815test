<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    // プロフィール表示用のメゾット
    public function show()
    {
        // ログイン中のユーザープロフイールを取得
        $profile = auth()->user()->profile()->firstOrFail();

        // ビューにデータを渡して表示
        return view('profiles.show', compact('profile'));
    }

    // プロフィールの新規作成フォーム表示
    public function create()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('profiles.create', compact('user'));
        }

        return redirect()->route('login')->with('error', 'ログインが必要です');
    }

    // プロフィールを新規作成するメソッド
    public function store(ProfileRequest $request)
    {
        // プロフィールデータを作成および保存
        $profileData = $request->only(['post_code', 'address', 'building']);
        $profileData['user_id'] = Auth::id();

        if ($request->hasFile('img_url')) {
            $profileData['img_url'] = $request->file('img_url')->store('profiles', 'public');
        }

        Profile::create($profileData);

        // ユーザー名の更新
        Auth::user()->update(['name' => $request->name]);

        return redirect()->route('profile.show')->with('success', 'プロフィールが作成されました');
    }

    // プロフィール編集ページ表示用
    public function edit()
    {
        // ログイン中のユーザープロフィールを取得
        $profile = auth()->user()->profile()->firstOrFail();

        // ビューにデータを渡して表示
        return view('profiles.edit', compact('profile'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrFail();

        // ユーザー名とプロフィール情報を更新
        $user->update(['name' => $request->name]);
        $profile->update($request->only(['post_code', 'address', 'building']));

        // 画像がアップロードされている場合の処理
        if ($request->hasFile('img_url')) {
            $this->updateProfileImage($profile, $request->file('img_url'));
        }

        // プロフィール更新後にプロフィール詳細ページにリダイレクトし、成功メッセージを表示
        return redirect()->route('profile.show')->with('success', 'プロフィールが更新されました');
    }

        // プロフィール画像の更新
    private function updateProfileImage($profile, $file)
    {
        // 古い画像のパス取得と新しい画像の保存
        $oldImagePath = $profile->img_url;
        $newImagePath = $file->storeAs('public/profiles', time() . '_' . $file->getClientOriginalName());

        // プロフィールを更新し古いファイルを削除
        $profile->update(['img_url' => 'profiles/' . basename($newImagePath)]);
        if ($oldImagePath) {
            Storage::delete('public/' . $oldImagePath);
        }
    }
}
