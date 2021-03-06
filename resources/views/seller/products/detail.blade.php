@extends('layouts.base')

@section('content')
    <div class="container">
        <h1 class="h1 mb-3">商品詳細</h1>
        <div class="mb-2">
            <div class="mb-2">
                <img src="{{ asset($product->img) }}" alt="">
            </div>
            <table class="table table-striped">
                <tr>
                    <th>商品ID</th>
                    <td>{{ $product->id }}</td>
                </tr>
                <tr>
                    <th>商品名</th>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <th>説明</th>
                    <td>{{ $product->description }}</td>
                </tr>
                <tr>
                    <th>価格</th>
                    <td>¥{{ $product->price }}</td>
                </tr>
                <tr>
                    <th>在庫数</th>
                    <td>{{ $product->stock_number }}個</td>
                </tr>
                <tr>
                    <th>安全在庫数</th>
                    <td>{{ $product->safety_stock_number }}個</td>
                </tr>
                <tr>
                    <th>カテゴリ</th>
                    <td>{{ $product->productCategory->name }}</td>
                </tr>
                <tr>
                    <th>ステータス</th>
                    <td>{{ $product->productStatus->name }}</td>
                </tr>
                <tr>
                    <th>登録日</th>
                    <td>{{ $product->created_at }}</td>
                </tr>
            </table>
        </div>
        <div>
            <a href="{{ url('/seller/products') }}">< 戻る</a>
        </div>
    </div>
@endsection