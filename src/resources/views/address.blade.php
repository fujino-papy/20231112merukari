@extends('layouts.logined')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container">
    <div class="address-form-container">
        <h2>住所変更</h2>
        <form action="{{ route('addressEdit') }}" method="post">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="form-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code" value="{{ Auth::user()->post }}" required>
            </div>

            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" id="address" name="address" value="{{ Auth::user()->address }}" required>
            </div>

            <div class="form-group">
                <label for="building_name">建物名</label>
                <input type="text" id="building_name" name="building_name" value="{{ Auth::user()->building_name }}">
            </div>

            <button type="submit" class="change-button">変更する</button>
        </form>
    </div>
</div>

@endsection