<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\BulkEmail;

class AdminController extends Controller
{
    // 全登録ユーザーを表示する
    public function showUsers()
    {
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    // ユーザーを削除する（管理者は削除出来ない）
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role == 0) {
            return redirect()->route('admin.users')->with('error', '管理者は削除できません。');
        }
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'ユーザーが削除されました。');
    }

    // 商品コメントを削除する
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'コメントを削除しました。');
    }

    // メールを送信する
    public function sendEmail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new BulkEmail($request->subject, $request->message));
        }

        return redirect()->back()->with('success', 'メールを送信しました。');
    }
}
