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
                            <input type="file" class="form-control-file" id="image_url" name="image_url" onchange="previewImage(event)">
                            <img id="image_preview" class="image-preview" src="#" alt="Image Prev
                            iew" style="display: none;">
                        </div>
                        <h2 class="sub">商品の詳細</h2>
                        <div class="item-detail">
                            <div class="form-group">
                                <label class="item-font" for="category">カテゴリー</label>
                                <select class="form-control" id="category" name="category" required>
                                    <option value=" disabled selected ">選択してください</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="item-font" for="condition">商品の状態</label>
                                <select class="form-control" id="condition" name="condition" required>
                                    <option value=" disabled selected ">選択してください</option>
                                    @foreach($conditions as $condition)
                                        <option value="{{ $condition->condition }}">{{ $condition->condition }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h2 class="sub">商品名と説明</h2>
                        <div class="item-detail">
                            <div class="form-group">
                                <label class="item-font" for="name">商品名</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="item-font" for="brand">ブランド</label>
                                <input type="text" class="form-control" id="brand" name="brand">
                            </div>
                            <div class="form-group">
                                <label class="item-font" for="comment">商品の説明</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                            </div>
                        </div>
                        <h2 class="sub">販売価格</h2>
                        <div class="form-group">
                            <label class="item-font" for="price">価格</label>
                            <input type="text" class="form-control" id="price" name="price" required value="¥">
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
