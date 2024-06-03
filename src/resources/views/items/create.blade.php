@extends('layouts.app')

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
                    <h1>商品の出品</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('items.create') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="image_url">商品画像</label>
                            <input type="file" class="form-control-file" id="image_url" name="image_url">
                        </div>

                        <h2>商品の詳細</h2>
                        <div class="item-detail">
                            <div class="form-group">
                                <label for="category">カテゴリー</label>
                                <select class="form-control" id="category" name="category" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="condition">商品の状態</label>
                                <select class="form-control" id="condition" name="condition" required>
                                    @foreach($conditions as $condition)
                                        <option value="{{ $condition->condition }}">{{ $condition->condition }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h2>商品名と説明</h2>
                        <div class="item-detail">
                            <div class="form-group">
                                <label for="name">商品名</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="brand">ブランド</label>
                                <input type="text" class="form-control" id="brand" name="brand">
                            </div>

                            <div class="form-group">
                                <label for="comment">商品の説明</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                            </div>
                        </div>

                        <h2>販売価格</h2>
                        <div class="form-group">
                            <label for="price">価格</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>

                        <button type="submit" class="btn btn-primary">出品する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
