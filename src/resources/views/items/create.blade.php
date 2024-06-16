@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/create.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="card-header">
                    <h1 class="main">商品の出品</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('items.create') }}" enctype="multipart/form-data">
                        @csrf
                        <h2 class="item-font">商品画像</h2>
                        <div class="form-group image-preview-container">
                            <label for="image_url" class="image-upload" id="image-label">画像を選択する</label>
                            <input type="file" class="form-control-file @error('image_url') is-invalid @enderror" id="image_url" name="image_url" onchange="previewImage(event)">
                            <img id="image_preview" class="image-preview" src="{{ session('image_url', '#') }}" alt="Image Preview" style="{{ session('image_url') ? '' : 'display: none;' }}">
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <h2 class="sub">商品の詳細</h2>
                        <div class="item-detail">
                            <div class="form-group">
                                <label class="item-font" for="category">カテゴリー</label>
                                <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="" disabled selected>選択してください</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category }}" {{ old('category') == $category->category ? 'selected' : ''}}>{{ $category->category }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="item-font" for="condition">商品の状態</label>
                                <select class="form-control @error('condition') is-invalid @enderror" id="condition" name="condition" required>
                                    <option value="" disabled selected>選択してください</option>
                                    @foreach($conditions as $condition)
                                        <option value="{{ $condition->condition }}" {{ old('condition') == $condition->condition ? 'selected' : '' }}>{{ $condition->condition }}</option>
                                    @endforeach
                                </select>
                                @error('condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <h2 class="sub">商品名と説明</h2>
                        <div class="item-detail">
                            <div class="form-group">
                                <label class="item-font" for="name">商品名</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="item-font" for="brand">ブランド</label>
                                <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand') }}">
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="item-font" for="comment">商品の説明</label>
                                <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <h2 class="sub">販売価格</h2>
                        <div class="form-group">
                            <label class="item-font" for="price">価格</label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">出品する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('image_preview');
            output.src =reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);

        var imageLabel = document.getElementById('image-label');
        imageLabel.textContent = '画像を変更する';
    }
</script>
@endsection
