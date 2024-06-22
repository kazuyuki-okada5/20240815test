@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/shipping_change.css') }}">
@endsection

@section('content')
<div class="shipping-change-container">
    <h2>配送先変更</h2>
    <form action="{{ route('shipping.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="post_code">郵便番号</label>
            <input type="text" name="post_code" id="post_code" class="form-control" value="{{ old('post_code', $shipping->post_code ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $shipping->address ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" class="form-control" value="{{ old('building', $shipping->building ?? '') }}">
        </div>

        <button type="submit" class="btn btn-primary">追加する</button>
    </form>
</div>
@endsection



