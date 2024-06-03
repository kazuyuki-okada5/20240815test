@extends('layouts.app')

@section('content')
<div class="container">
    @if ($profile)
        <h1>{{ $profile->user->name }}のプロフィール</h1>
        <div class="profile">
            <!-- プロフィール画像を表示 -->
            <img src="{{ asset('storage/' . $profile->img_url) }}" alt="Profile Image" style="max-width: 200px;">
            <!-- ユーザーのプロフィール情報を表示 -->
            <p>郵便番号: {{ $profile->post_code }}</p>
            <p>住所: {{ $profile->address }}</p>
            <p>建物名: {{ $profile->building }}</p>
        </div>
    @else
        <p>プロフィール情報がありません。</p>
    @endif
        <a href="{{ route('profile.edit')}}" class="btn btn-primary">プロフィールを編集する</a>
</div>
@endsection