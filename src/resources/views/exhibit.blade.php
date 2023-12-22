<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/exhibit.css') }}">
</head>

<body class="exhibit">
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
            COACHTECH
        </a>
        </div>
    </header>

    <main>
        <div class="exhibit_content">
        <h1 class="exhibit_ttl">商品の出品</h1>
        <form method="post" action="{{ route('items.store') }}" enctype="multipart/form-data">
            @csrf
            <label class="exhibit_content" for="image">商品画像:</label>
            <div class="custom-file-input">
                <div class="image-preview" id="imagePreview"></div>
                </div>
                <label class="file-upload-btn">
                    画像を追加
                    <div class="image">
                    <input class="image" type="file" name="image" accept="image/*" required onchange="previewImage(this);">
                    </div>
                </label>
            <br>

            <p class="item_detail">商品の詳細</p>
            <label class="exhibit_content" for="category">カテゴリー:</label>
            <select class="category" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->categories }}</option>
                @endforeach
            </select>
            <br>

            <label class="exhibit_content" for="condition">商品の状態:</label>
            <select class="condition" name="condition_id" required>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->conditions }}</option>
                @endforeach
            </select>
            <br>
            <p class="item_name">商品名と説明</p>
            <label class="exhibit_content" for="name">商品名:</label>
            <input class="name" type="text" name="name" required>
            <br>
            <label class="exhibit_content" for="summary">商品の説明:</label>
            <textarea class="summary" name="summary" required></textarea>
            <br>

            <p class="item_price">販売価格</p>
            <label class="exhibit_content" for="price">販売価格:</label>
            <input class="price" type="text" name="price" placeholder="￥" required>
            <br>

            <button class="exhibit_button" type="submit">出品する</button>
        </form>
        </div>
    </main>
    <script>
        function previewImage(input) {
            var preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            var files = input.files;

            if (files.length > 0) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;

                    preview.appendChild(img);
                }

                reader.readAsDataURL(files[0]);
            }
        }
    </script>
</body>

</html>