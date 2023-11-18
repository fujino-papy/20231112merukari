@extends('layouts.logined')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/buy.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="item-container">
        <div class="item">
            <div class="item-content">
                <div class="item_img">
                    <img class="img" src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
                </div>
                <div class="item-info">
                    <h2 class="item-name">{{ $item->name }}</h2>
                    <p class="price">￥{{ $item->price }}</p>
                </div>
            </div>
        </div>
        <div class="price-info-container">
            <div class="price-info-box">
                <div class="price-info">
                    <ul class="payment-methods">
                        <li class="item_price">商品代金　￥{{ $item->price }}</li>
                        <li class="total_price">支払金額￥{{ $item->price }}</li>
                        <li class="pay">支払方法　</li>
                    </ul>
                </div>
            </div>
                            <div class="button">
                    <button class="buy-button">購入する</button>
                </div>
        </div>
    </div>
</div>
@endsection