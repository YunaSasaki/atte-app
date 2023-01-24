@extends('layouts.default')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('/css/attendance.css') }}" />
@endsection

@section('header')
<nav>
  <ul>
    <li>
      <form method="GET" action="/">
        @csrf
        <input class="nav" type="submit" value="ホーム" />
      </form>
    </li>
    <li>
      <form method="GET" action="/attendance">
        @csrf
        <input class="nav" type="submit" value="日付一覧" />
      </form>
    </li>
    <li>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <input class="nav" type="submit" value="ログアウト" />
      </form>
    </li>
  </ul>
</nav>
@endsection

@section('main')
<table class="display">
  <tr>
    <th>名前</th>
    <th>勤務開始</th>
    <th>勤務終了</th>
    <th>休憩時間</th>
    <th>勤務時間</th>
  </tr>
  @foreach ($stamps as $stamp)
  <tr>
    <td>{{ $stamp->user->name }}</td>
    <td>10:00:00</td>
    <td>20:00:00</td>
    <td>00:30:00</td>
    <td>09:30:00</td>
  </tr>
  @endforeach
</table>

{!! $stamps->links('vendor.pagination.bootstrap-4') !!}
@endsection