@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profiles/show.css') }}">
@endsection

@section('content')
<div class="profile-container">
    @if ($profile)
        <h1 class="profile-title">{{ $profile->user->name }}のプロフィール</h1>
        <div class="profile">
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
            <p class="profile-item">郵便番号: {{ $profile->post_code }}</p>
            <p class="profile-item">住所: {{ $profile->address }}</p>
            <p class="profile-item">建物名: {{ $profile->building }}</p>
        </div>
    @else
        <p class="no-profile">プロフィール情報がありません。</p>
    @endif
    <div class="button-container">
        <a href="{{ route('profile.edit')}}" class="btn btn-primary">プロフィールを編集する</a>
        <br>
        <a href="{{ route('mypage') }}" class="btn btn-primary">マイページに戻る</a>
    </div>
</div>
@endsection

