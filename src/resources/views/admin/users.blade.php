@extends('layouts.app')

@section('content')
<div class="conteiner">
    <h1>ユーザー管理</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>役割</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role == 0 ? '管理者' : 'ユーザー' }}</td>
                    <td>
                        @if($user->role != 0) <!-- 管理者は削除出来ない-->
                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
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