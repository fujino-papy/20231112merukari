@extends('layouts.logined')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


        <p>購入が完了しました</p>

        <a href="/">
        トップページへ戻る
        </a>
@endsection