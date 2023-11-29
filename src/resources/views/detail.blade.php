@extends('layouts.logined')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
        <div class="item_img">
            <img class="img" src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
        </div>
        <div class="item-details">
        <p class="item_name">{{ $item->name }}</p>
            <p class="item_price">￥{{ $item->price }}</p>
            @auth
        <form action="{{ route('buyPage',['item_id' => $item->id]) }}" method="get">
            @csrf
            <button type="submit" class="buyPage">購入する</button>
        </form>
        @else
        <form action="{{ route('login') }}" method="get">
            <button class="buyPage" class="buy">購入する</button>
        </form>
        @endauth

            <p class="summary">商品説明</p>
            <p class="item_summary">{{$item->summary}}</p>
            <p class="info">商品の情報</p>
            <p class="item_category">カテゴリー：{{$item->category->categories}}</p>
            <p class="item_condition">商品の状態：{{$item->condition->conditions}}</p>
        </div>
@endsection