<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class AuthController extends Controller
{
    // ユーザーがこのコンローラーの’login’アクションにアクセスした時、resources/views/auth/login.blade.phpファイルが表示される
        public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // 認証に成功した場合の処理
            return redirect()->intended('/');
        }

        // 認証に失敗した場合の処理
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが間違っています。',
        ])->withInput();
    }

        public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        // ユーザーの作成
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // ユーザーの自動ログイン
        Auth::login($user);

        // リダイレクト先
        return redirect()->intended('/');
    }

        public function mypage()
        {
            $user = Auth::user();

            return view('Auth.mypage', compact('user'));
        }

}
