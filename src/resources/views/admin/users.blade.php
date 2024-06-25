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


