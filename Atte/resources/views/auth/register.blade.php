@extends('layouts.default')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('/css/register.css') }}" />
@endsection

@section('header', '')

@section('main')
<div class="wrapper">
  <h2 class="title">会員登録</h2>
  <form method="POST">
    @csrf
    <input type="text" name="name" placeholder="名前" value="{{ old('name') }}" autocomplete="off" />
    @error('name')
    <p class="error">{{$message}}</p>
    @enderror
    <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}" autocomplete="off" />
    @error('email')
    <p class="error">{{$message}}</p>
    @enderror
    <input type="password" name="password" placeholder="パスワード" autocomplete="new-password" />
    @error('password')
    <p class="error">{{$message}}</p>
    @enderror
    <input type="password" name="password_confirmation" placeholder="確認用パスワード" autocomplete="off" />
    @error('password_confirmation')
    <p class="error">{{$message}}</p>
    @enderror
    <button type="submit" formaction="{{ route('register') }}">会員登録</button>
  </form>
  <p class="text">
    アカウントをお持ちの方はこちら
  </p>
  <a class="login" href="{{ route('login') }}">ログイン</a>
</div>
@endsection

@section('js', '')