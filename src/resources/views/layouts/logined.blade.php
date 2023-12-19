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
        <div class="header-utilities">
        <a class="header__logo" href="/">
            COACHTECH
        </a>
        </div>
        <div class="header-search">
                <form class="search_form" action="{{ route('search') }}" method="GET">
                    <label class="label">
                    <input class="search_input" type="text" name="query" placeholder="なにかお探しですか？">
                    </label>
                    <button class="search_button" type="submit"></button>
                </form>
        </div>
        <nav class="header-nav">
            <ul class="header-links">
                @if (Auth::check())
            <li class="header-nav__item">
                <form class="header-nav_form" action="/logout" method="post">
                @csrf
                <button class="header-nav__button">ログアウト</button>
                </form>
            </li>
            <li class="header-nav__item">
                <a class="header-nav__link" href="/mypage">マイページ</a>
            </li>
            @else
                <li class="header-nav__item">
                <a class="header-nav__link" href="/register">会員登録</a>
            </li>
            <li class="header-nav__item">
                <a class="header-nav__link" href="/login">ログイン</a>
            </li>
            @endif
            <li class="header-nav__item">
                <a class="exhibit" href="{{ Auth::check() ? '/exhibit' : '/login' }}">出品</a>
            </li>
            </ul>
        </nav>
        </div>
    </div>
    </header>

    <main>
    @yield('content')
    </main>
</body>

</html>