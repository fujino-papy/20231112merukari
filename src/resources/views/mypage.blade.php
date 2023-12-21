@extends('layouts.logined')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')


<div class="mypage">
    <div class="profile">
    <img class="profile-img" src="{{ asset(Auth::user()->img_url ) }}">
        <div class="profile-name">
        <p>{{ Auth::user()->name }}</p>
        </div>
        <form class="profile_form" action="{{ route('profile') }}" method="get">
        <button class="profile_button">プロフィール編集</button>
        </form>
    </div>


    <div class="tabs">
    <button class="exhibit-btn" onclick="showItems('selling')">出品した商品</button>
    <button class="buy-btn" onclick="showItems('buying')">購入した商品</button>
    </div>

    <div class="items" id="selling-items">
        <div class="items-container">
        @foreach($sellingItems as $item)
            <div class="item">
                <img class="item_img" src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
                                <a class="detail" href="{{ route('detail', ['item_id' => $item->id]) }}" class="detail">商品詳細</a>
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

    <div class="items" id="buying-items" style="display: none;">
    <!-- 購入した商品の表示 -->
    <div class="items-container">
        @foreach($boughtItemsDetails as $item)
            <div class="item">
                <img class="item_img" src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
                <a class="detail" href="{{ route('detail', ['item_id' => $item->id]) }}" class="detail">商品詳細</a>
                <div class="item-details">
                    <p class="item_name">{{ $item->name }}</p>
                    <p class="item_price">Price: ￥{{ $item->price }}</p>
                    <!-- その他の商品詳細情報の表示 -->
                </div>
            </div>
        @endforeach
    </div>
</div>

</div>

<script>
    function showItems(tab) {
        if (tab === 'selling') {
            document.getElementById('selling-items').style.display = 'block';
            document.getElementById('buying-items').style.display = 'none';
        } else {
            document.getElementById('selling-items').style.display = 'none';
            document.getElementById('buying-items').style.display = 'block';
        }
    }
</script>

@endsection