<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
        public function items()
    {
        return view('items.item');
    }
    // ユーザーがこのコンローラーの’items’アクションにアクセスした時、resources/views/items/items.blade.phpファイルが表示される

        public function login()
    {
        return view('auth.login');
    }

        public function register()
    {
        return view('auth.register');
    }

}
