<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
        </div>
    </header>

    <main>
        <form method="post" action="{{ route('items.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- 商品画像 -->
            <label for="image">商品画像:</label>
            <input type="file" name="image" accept="image/*" required>
            <br>

            <!-- カテゴリー -->
            <label for="category">カテゴリー:</label>
            <select name="category_id" required>
                <!-- カテゴリーの選択肢を動的に取得するロジックを追加 -->
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->categories }}</option>
                @endforeach
            </select>
            <br>

            <!-- 商品の状態 -->
            <label for="condition">商品の状態:</label>
            <select name="condition_id" required>
                <!-- 商品の状態の選択肢を動的に取得するロジックを追加 -->
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->conditions }}</option>
                @endforeach
            </select>
            <br>

            <!-- 商品名 -->
            <label for="name">商品名:</label>
            <input type="text" name="name" required>
            <br>

            <!-- 商品の説明 -->
            <label for="summary">商品の説明:</label>
            <textarea name="summary" required></textarea>
            <br>

            <!-- 販売価格 -->
            <label for="price">販売価格:</label>
            <input type="number" name="price" required>
            <br>

            <!-- 出品ボタン -->
            <button type="submit">出品する</button>
        </form>
    </main>
</body>

</html>