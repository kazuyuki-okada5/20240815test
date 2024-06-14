@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profiles/create.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h1 class="profile-title">プロフィール作成</h1>
    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="img_url" class="form-label">プロフィール画像</label>
            <input type="file" class="form-control-file" id="img_url" name="img_url">
        </div>
        <div class="form-group">
            <label for="post_code" class="form-label">郵便番号</label>
            <input type="text" class="form-control" id="post_code" name="post_code">
        </div>
        <div class="form-group">
            <label for="address" class="form-label">住所</label>
            <input type="text" class="form-control" id="address" name="address">
        </div>
        <div class="form-group">
            <label for="building" class="form-label">建物名</label>
            <input type="text" class="form-control" id="building" name="building">
        </div>
        <button type="submit" class="btn btn-primary">プロフィールを作成</button>
    </form>
</div>
@endsection