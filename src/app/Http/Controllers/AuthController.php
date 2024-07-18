<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ログイン画面表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ログイン処理
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

    // 会員登録画面表示
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 会員登録処理
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

        return redirect()->intended('/');
    }

    // 認証前ユーザーがログアウトリクエストした時のリダイレクト先
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
