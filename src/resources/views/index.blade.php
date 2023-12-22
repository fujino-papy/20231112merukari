@extends('layouts.logined')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="tabs">
        <button class="index-btn" onclick="showItems('index')">おすすめ</button>
        <button class="fav-btn" onclick="showItems('favorite')">マイリスト</button>
    </div>

    <div class="items" id="favorite-items" style="display: none;">
        <div class="items-container">

            @guest
                <p>ログインもしくは会員登録してください</p>
            @else
            @foreach($favoriteItems as $item)
                <div class="item">
                    <img class="item_img" src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
                    <a class="detail" href="{{ route('detail', ['item_id' => $item->id]) }}">商品詳細</a>
                    <div class="item-details">
                        <p class="item_name">{{ $item->name }}</p>
                        <p class="item_price">Price: ￥{{ $item->price }}</p>
                        @if($item->isSoldOut)
                            <p class="sold-out">Sold Out</p>
                        @endif
                    </div>
                </div>
            @endforeach
            @endguest
        </div>
    </div>

    <div class="items" id="index-items" >
        <div class="items-container">
            @foreach($items as $item)
                <div class="item">
                    <img class="item_img" src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
                    <a class="detail" href="{{ route('detail', ['item_id' => $item->id]) }}">商品詳細</a>
                    <div class="item-details">
                        <p class="item_name">{{ $item->name }}</p>
                        <p class="item_price">Price: ￥{{ $item->price }}</p>
                        @if($item->isSoldOut)
                            <p class="sold-out">Sold Out</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="pagination">
        {{ $items->links() }}
    </div>

    <script>
        function showItems(tab) {
            if (tab === 'favorite') {
                document.getElementById('favorite-items').style.display = 'block';
                document.getElementById('index-items').style.display = 'none';
            } else {
                document.getElementById('favorite-items').style.display = 'none';
                document.getElementById('index-items').style.display = 'block';
            }
        }
    </script>
@endsection