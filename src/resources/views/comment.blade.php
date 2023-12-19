@extends('layouts.logined')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="item-images">
        <img class="images" src="{{ asset($item->image_url) }}" alt="商品画像">
    </div>
    <div class="item-detail">
        <div class="item-info">
            <h2>{{ $item->name }}</h2>
            <p>¥{{ $item->price }}</p>
        </div>
        <div class="icon">
            <div class="favorite_button">
                <div class="favorite_buttons_container">
                @if(auth()->check())
                        @if($isFavorite)
                            <form class="favoriteDelete" action="{{ route('favoriteDelete', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ster"><img class="ster_img" src="{{ asset('img/ster_on.png') }}" alt="on"></button>
                            </form>
                        @else
                            <form class="favorite" action="{{ route('favorite', $item->id) }}" method="post">
                                @csrf
                                <button type="submit" class="ster"><img class="ster_img" src="{{ asset('img/ster_off.png') }}" alt="off"></button>
                            </form>
                        @endif
                        <a class="comment_icon" href="{{ route('comment', ['item_id' => $item->id]) }}"><img class="comment_img" src="{{ asset('img/comment.png') }}" alt="Comment"></a>
                    @else
                        <img class="ster_img" src="{{ asset('img/ster_off.png') }}" alt="off">
                        <a class="comment_icon" href="{{ route('comment', ['item_id' => $item->id]) }}"><img class="comment_img" src="{{ asset('img/comment.png') }}" alt="Comment"></a>
                    @endif
                </div>
            </div>
            <div class="counts">
                <a class="favorite_count">{{ $favoriteCount }}</a>
                <a class="comment_count">{{ $commentCount }}</a>
            </div>
        </div>

                <div class="comments">
                    @foreach($comments as $comment)
                    <div class="comment">
                        <img class="user_img" src="{{ $comment->user->img_url }}" alt="プロフィール画像">
                        <span class="user_name">{{ $comment->user->name }}</span>
                        <p class="user_comment">{{ $comment->comment }}</p>
                    </div>
                @endforeach
                </div>
                <div class="comment_form">
                    <h2>コメント</h2>
                    @if(auth()->check())
                        <!-- ログインしている場合、コメント送信フォームを表示 -->
                        <form action="{{ route('commentPost') }}" method="post">
                                @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <div class="form-group">
                                <label for="comment">コメント</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">コメントを送信する</button>
                        </form>
                    @else
                        <!-- ログインしていない場合、ログイン画面へ遷移するボタンを表示 -->
                        <a href="{{ route('login') }}" class="btn btn-primary">ログインしてコメントする</a>
                    @endif
                </div>
    </div>
</div>
@endsection