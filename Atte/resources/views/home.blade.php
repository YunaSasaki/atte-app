@extends('layouts.default')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('/css/home.css') }}" />
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
<div class="wrapper">
  <h2 class="message">{{$user->name}}さんお疲れ様です！</h2>
  <form method="POST">
    @csrf
    <div class="box-outer">
      <div class="box-1">
        @if ($work_start == 'on')
        <button class="button-on" type="submit" formaction="/work/start">勤務開始</button>
        @elseif ($work_start == 'off')
        <button class="button-off" disabled>勤務開始</button>
        @endif
      </div>
      <div class="box-2">
        @if ($work_end == 'on')
        <button class="button-on" type="submit" formaction="/work/end">勤務終了</button>
        @elseif ($work_end == 'off')
        <button class="button-off" disabled>勤務終了</button>
        @endif
      </div>
      <div class="box-3">
        @if ($rest_start == 'on')
        <button class="button-on" type="submit" formaction="/rest/start">休憩開始</button>
        @elseif ($rest_start == 'off')
        <button class="button-off" disabled>休憩開始</button>
        @endif
      </div>
      <div class="box-4">
        @if ($rest_end == 'on')
        <button class="button-on" type="submit" formaction="/rest/end">休憩終了</button>
        @elseif ($rest_end == 'off')
        <button class="button-off" disabled>休憩終了</button>
        @endif
      </div>
    </div>
  </form>
</div>
@if ($clear != '')
<div class="clear_message">
  {{$clear}}
</div>
@endif
@if ($error != '')
<div class="error_message">
  {{$error}}
</div>
@endif
@endsection

@section('js', '')