<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;

class AdminController extends Controller
{
    public function showUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // 管理者は削除出来ない
        if ($user->role == 0) {
            return redirect()->route('admin.users')->with('error', '管理者は削除できません。');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('succes', 'ユーザーが削除されました。');
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'コメントを削除しました。');
    }

}
