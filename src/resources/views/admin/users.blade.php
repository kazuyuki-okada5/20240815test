@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/user.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="title">ユーザー管理</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    <div class="mail-form">
        <form action="{{ route('admin.users.sendEmail') }}" method="POST">
            @csrf
                <div class="form-group">
                    <label class="form-group-label" for="subject">件名</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-group-label" for="message">本文</label>
                    <textarea name="message" class="form-control" rows="5" required></textarea>
                </div>
                <div class="form-group button-right">
                    <button type="submit" class="btn btn-primary">全員にメールを送信</button>
                </div>
        </form>
    </div>
    <table class="table table-striped">
        <thead>
            <tr class="table-header-row">
                <th class="table-header">ID</th>
                <th class="table-header">名前</th>
                <th class="table-header">メールアドレス</th>
                <th class="table-header">役割</th>
                <th class="table-header">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="table-row">
                    <td class="table-cell-id">{{ $user->id }}</td>
                    <td class="table-cell">{{ $user->name }}</td>
                    <td class="table-cell">{{ $user->email }}</td>
                    <td class="table-cell-role">{{ $user->role == 0 ? '管理者' : 'ユーザー' }}</td>
                    <td class="table-cell-button">
                        @if($user->role != 0) <!-- 管理者は削除出来ない-->
                            <form class="delete-form" action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection



