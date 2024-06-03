<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        $user = user::findOFail($id);
        return view('items.detail', compact('user'));
    }
}
