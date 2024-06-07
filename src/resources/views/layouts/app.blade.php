<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flea Market App</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
        <a class="header__logo" href="/">
          Flea Market App
        </a>
        <!-- 検索フォームをフレックスボックスで設置　-->
        <div class="header__search">
          <form class="form" action="{{ route('items.search') }}" method="get">
            <input type="text" name="query" placeholder="なにをお探しですか？">
            <button class="header-nav__button">検索</button>
          </form>
        </div>
        <nav>
          <ul class="header-nav">

            {{-- 商品検索用テキスト追加する --}}

            @if (Auth::check()){
            <li class="header-nav__item">

              <a class="header-nav__link" href="{{ route('items.create') }}">出品</a>
              </form>
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
            }@else{
            <li class="header-nav__item">
              <a class="header-nav__link" href="/">トップページ</a>
            </li>
            
            <li class="header-nav__item">
              <a class="header-nav__link" href="/login">ログイン</a>
            </li>
            <li class="header-nav__item">
              <a class="header-nav__link" href="/register">会員登録</a>
            </li>              
            }
            </li>
            @endif
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