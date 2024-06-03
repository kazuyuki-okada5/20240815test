<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

}
