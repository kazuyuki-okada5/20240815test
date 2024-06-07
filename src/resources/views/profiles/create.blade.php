@extends('layouts.app')

@section('content')
<div class="container">
    <h1>プロフィール作成</h1>
    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="img_url">プロフィール画像</label>
            <input type="file" class="form-control-file" id="img_url" name="img_url">
        </div>
        <div class="form-group">
            <label for="post_code">郵便番号</label>
            <input type="text" class="form-control" id="post_code" name="post_code">
        </div>
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" class="form-control" id="address" name="address">
        </div>
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" class="form-control" id="building" name="building">
        </div>
        <button type="submit" class="btn btn-primary">プロフィールを作成</button>
    </form>
</div>
@endsection