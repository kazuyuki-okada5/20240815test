@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/item.css') }}">
@endsection

@section('content')


<div class="listtype__content">
  <div class="listtype__list">
          <ul class="listtype-nav">
            <li class="listtype-nav__item">
              <form class="form" action='/' method="get">
                @csrf
                <button class="listtype-nav__button">おすすめ</button>
              </form>
            </li>

            @if (Auth::check())
            <li class="listtype-nav__item">
              <form class="form" action='/item/{item_id}' method="get">
                @csrf
                <button class="listtype-nav__button">マイリスト</button>
              </form>
            </li>
            @endif
          </ul>
    </div>
  </div>
  <div class="attendance-table">
    <table class="attendance-table__inner">
      <tr class="attendance-table__row">
        <th class="attendance-table__header">名前</th>
        <th class="attendance-table__header">開始時間</th>
        <th class="attendance-table__header">終了時間</th>
      </tr>
      <tr class="attendance-table__row">
        <td class="attendance-table__item">サンプル太郎</td>
        <td class="attendance-table__item">サンプル</td>
        <td class="attendance-table__item">サンプル</td>
      </tr>
    </table>
  </div>
</div>
@endsection