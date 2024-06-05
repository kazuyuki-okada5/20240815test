<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class AuthController extends Controller
{
    // ユーザーがこのコンローラーの’login’アクションにアクセスした時、resources/views/auth/login.blade.phpファイルが表示される
        public function login()
    {
        return view('auth.login');
    }

        public function register()
    {
        return view('auth.register');
    }

        public function mypage()
        {
            $user = Auth::user();

            return view('Auth.mypage', compact('user'));
        }

}
