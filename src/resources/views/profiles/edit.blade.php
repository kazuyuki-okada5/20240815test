@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profiles/edit.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h1 class="profile-title">プロフィール編集</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="img_url" class="form-label">プロフィール画像</label>
            <div class="profile-image-parent">
                <div class="profile-image-container">
                    @if ($profile->img_url)
                        <img id="profile-image-preview" src="{{ $profile->img_url }}" alt="Profile Image" class="profile-image">
                    @else
                        <div class="default-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                    @endif
                </div>
            </div>
            <input type="file" class="form-control-file" id="img_url" name="img_url" onchange="previewImage(event)">
            @error('img_url')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="name" class="form-label">ユーザー名</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $profile->user->name) }}">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="post_code" class="form-label">郵便番号（ハイフンなし）</label>
            <input type="text" class="form-control" id="post_code" name="post_code" value="{{ old('post_code', $profile->post_code) }}">
            @error('post_code')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="address" class="form-label">住所</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $profile->address) }}">
            @error('address')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="building" class="form-label">建物名</label>
            <input type="text" class="form-control" id="building" name="building" value="{{ old('building', $profile->building) }}">
            @error('building')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection

