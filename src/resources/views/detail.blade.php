@extends('layouts.logined')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="item-details-container">
        <img src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
        <div class="item-details">
            <p>{{ $item->name }}</p>
            <p>Price: ￥{{ $item->price }}</p>
            <!-- 他の詳細を表示するためのコードを追加 -->
        </div>
    </div>
    <!-- 他のコンテンツを追加 -->

@endsection