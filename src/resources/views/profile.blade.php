@extends('layouts.logined')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="profile-edit-container">

    <h1 class="profile_ttl">プロフィール設定</h1>

    <div class="profile-image">
        <img src="{{ asset(Auth::user()->img_url) }}" alt="プロフィール画像">
    </div>

    <div class="profile-form">
        <form action="{{ route('profileEdit') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="profile-image-button">
            <input class="img_url" type="file" name="img_url" id="img_url" accept="image/*">
            <label class="img_url" for="img_url">画像を選択する</label>
        </div>

            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}">
            </div>

            <div class="form-group">
                <label for="post">郵便番号</label>
                <input type="text" name="post" id="post" value="{{ Auth::user()->post }}">
            </div>

            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ Auth::user()->address }}">
            </div>

            <div class="form-group">
                <label for="building_name">建物名</label>
                <input type="text" name="building_name" id="building_name" value="{{ Auth::user()->building_name }}">
            </div>

            <button class="update_button" type="submit">更新する</button>
        </form>
    </div>

</div>

<script>
const imgUrlInput = document.getElementById('img_url');
const imgPreview = document.querySelector('.profile-image img');

imgUrlInput.addEventListener('change', () => {
    const img = imgUrlInput.files[0];
    const reader = new FileReader();

    reader.onload = () => {
        imgPreview.src = reader.result;
    };

    reader.readAsDataURL(img);
});
</script>
@endsection