@extends('layouts.logined')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')


    <div class="items-container">
        @foreach($items as $item)
            <div class="item">
                <img class="item_img" src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
                <a  class="detail"  href="{{ route('detail', ['id' => $item->id]) }}" class="detail">商品詳細</a>
                <div class="item-details">
                    <p class="item_name">{{ $item->name }}</p>
                    <p class="item_price">Price: ￥{{ $item->price }}</p>
                    @if($item->isSoldOut)
                    <p class="sold-out">Sold Out</p>
                    @endif
                    <!-- Add any other details you want to display -->
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $items->links() }}
    </div>
@endsection