<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flea Market App</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css')
</head>
<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header__inner">
                <div class="header__logo">
                    <img src="{{ asset('storage/logo (1).svg') }}" alt="Flea Market App Logo" class="logo">
                </div>
                <div class="header__search">
                    <form class="form" action="{{ route('items.search') }}" method="get">
                        <input type="text" name="query" class="search-input" placeholder="なにをお探しですか？">
                    </form>
                </div>
                <nav class="header-nav">
                    <ul class="header-nav__list">
                        @if (Auth::check())
                        @if (Auth::user()->role == 0)
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="{{ route('admin.users') }}">管理者ページ</a>
                        </li>
                        @endif
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="{{ route('items.create') }}">出品</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/">トップページ</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="{{ route('mypage') }}">マイページ</a>
                        </li>
                        <li class="header-nav__item">
                            <form class="form" action='/logout' method="post">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        @else
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/">トップページ</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/login">ログイン</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/register">会員登録</a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
