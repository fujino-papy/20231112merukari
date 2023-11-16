@extends('layouts.logined')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')


    <div class="items-container">
        @foreach($items as $item)
            <div class="item">
                <img src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
                <div class="item-details">
                    <p>{{ $item->name }}</p>
                    <p>Price: ￥{{ $item->price }}</p>
                    <!-- Add any other details you want to display -->
                </div>
                <a  class="detail"  href="{{ route('detail', ['id' => $item->id]) }}" class="detail">商品詳細</a>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $items->links() }}
    </div>
@endsection