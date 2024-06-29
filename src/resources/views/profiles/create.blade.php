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
            @if ($errors->has('img_url'))
                <div class="error-message">{{ $errors->first('img_url') }}</div>
            @endif
        </div>
         <div class="form-group">
            <label for="post_code" class="form-label">郵便番号（ハイフンなし）</label>
            <input type="text" class="form-control" id="post_code" name="post_code" value="{{ old('post_code') }}">
            @if ($errors->has('post_code'))
                <div class="error-message">{{ $errors->first('post_code') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="address" class="form-label">住所</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
            @if ($errors->has('address'))
                <div class="error-message">{{ $errors->first('address') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="building" class="form-label">建物名</label>
            <input type="text" class="form-control" id="building" name="building" value="{{ old('building') }}">
            @if ($errors->has('building'))
                <div class="error-message">{{ $errors->first('building') }}</div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">プロフィールを作成</button>
    </form>
</div>
@endsection

