@extends('layouts.default')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('/css/login.css') }}" />
@endsection

@section('header', '')

@section('main')
<div class="wrapper">
  <h2 class="title">ログイン</h2>
  <form method="POST">
    @csrf
    <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}" autocomplete="off" />
    @error('email')
    <p class="error">{{$message}}</p>
    @enderror
    <input type="password" name="password" placeholder="パスワード" autocomplete="new-password" />
    @error('password')
    <p class="error">{{$message}}</p>
    @enderror
    <button type="submit" formaction="{{ route('login') }}">ログイン</button>
  </form>
  <p class="text">
    アカウントをお持ちでない方はこちら
  </p>
  <a class="register" href="{{ route('register') }}">会員登録</a>
</div>
@endsection