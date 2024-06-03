@extends('layouts.app')

@section('content')
<div class="edit-container">
    <h1>プロフィール編集</h1>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="img_url">プロフィール画像</label>
            <input type="file" class="form-cotrol-file" id="img_url" name="img_url">
        </div>
        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $profile->user->name}}">
        </div>
        <div class="form-group">
            <label for="post_code">郵便番号</label>
            <input type="text" class="form-control" id="post_code" name="post_code" value="{{ $profile->post_code }}">
        </div>
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $profile->address }}">
        </div>
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" class="form-control" id="building" name="building" value="{{ $profile->building }}">
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection