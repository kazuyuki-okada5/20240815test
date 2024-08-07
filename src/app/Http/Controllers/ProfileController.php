<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    // プロフィール表示用のメゾット
    public function show()
    {
        $profile = auth()->user()->profile()->firstOrFail();

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
        $profileData = $request->only(['post_code', 'address', 'building']);
        $profileData['user_id'] = Auth::id();

        if ($request->hasFile('img_url')) {
            $path = $request->file('img_url')->store('profiles', 's3');
            $profileData['img_url'] = Storage::disk('s3')->url($path);
        }
        Profile::create($profileData);
        Auth::user()->update(['name' => $request->name]);

        return redirect()->route('profile.show')->with('success', 'プロフィールが作成されました');
    }

    // プロフィール編集ページ表示用
    public function edit()
    {
        $profile = auth()->user()->profile()->firstOrFail();

        return view('profiles.edit', compact('profile'));
    }

    // プロフィールフォーム更新
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrFail();
        $user->update(['name' => $request->name]);
        $profile->update($request->only(['post_code', 'address', 'building']));

        if ($request->hasFile('img_url')) {
            $this->updateProfileImage($profile, $request->file('img_url'));
        }

        return redirect()->route('profile.show')->with('success', 'プロフィールが更新されました');
    }

    // プロフィール画像の更新
    private function updateProfileImage($profile, $file)
    {
        $oldImagePath = $profile->img_url;
        $path = $file->store('profiles', 's3');
        $newImageUrl = Storage::disk('s3')->url($path);
        $profile->update(['img_url' => $newImageUrl]);
        if ($oldImagePath) {
            $oldPath = str_replace(env('AWS_URL') . '/', '', $oldImagePath);
            Storage::disk('s3')->delete($oldPath);
        }
    }
}
