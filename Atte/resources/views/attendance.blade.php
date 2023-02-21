@extends('layouts.default')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('/css/app.css') }}" />
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
        <input type="hidden" id="today" name="stamp_date" />
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
  <form class="date" id="submit_date" method="GET" action="/attendance">
    @csrf
    <!-- input date 本体 -->
    <input type="date" class="hidden_box" id="inp_date" name="stamp_date" value="{{ $stamp_date }}">
    <!-- 一日戻す -->
    <input type="button" class="btn_sub" id="btn_sub" value="&lt;">
    <!-- カレンダーを出す -->
    <input type="button" class="btn_picker" id="btn_picker" value="{{ $stamp_date }}">
    <!-- 一日進める -->
    <input type="button" class="btn_add" id="btn_add" value="&gt;">
  </form>
  <table class="display">
    <thead>
      <tr>
        <th>名前</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($stamps as $stamp)
      <tr>
        <td>{{ $stamp->user->name }}</td>
        <td>{{ $stamp->start_work }}</td>
        <td>{{ $stamp->end_work }}</td>
        <td>{{ $restTimes[$loop->index] }}</td>
        <td>{{ $workTimes[$loop->index] }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="pagination">
    {!! $stamps->links('vendor.pagination.bootstrap-4') !!}
  </div>
</div>
@endsection

@section('js')
<script>
  // Date関数で取得した日付をyyyy-mm-ddの形式にする関数
  function formatDate(date) {
    let yyyy = date.getFullYear();
    let mm = ("0" + (date.getMonth() + 1)).slice(-2);
    let dd = ("0" + date.getDate()).slice(-2);
    return yyyy + '-' + mm + '-' + dd;
  }

  // id="today"にデフォルトで今日の日付を設定する
  let today = formatDate(new Date());
  document.querySelector('#today').value = today;

  // カレンダーボタンがクリックされたときの処理
  document.querySelector('#btn_picker').addEventListener('click', (event) => {
    document.querySelector('#inp_date').showPicker();
  }, false);

  // 日付が選択されたときの処理
  document.querySelector('#inp_date').addEventListener('change', (event) => {
    // formを送信する
    let fm = document.querySelector('#submit_date');
    fm.submit();
  }, false);

  // stampDateを定義
  let stampDate = new Date('{{ $stamp_date }}');

  // 一日前のリストを表示
  document.querySelector('#btn_sub').addEventListener('click', (event) => {
    stampDate.setDate(stampDate.getDate() - 1);
    let dayBefore = formatDate(stampDate);
    document.querySelector('#inp_date').value = dayBefore;
    // formを送信する
    let fm = document.querySelector('#submit_date');
    fm.submit();
  }, false);

  // 一日後のリストを表示
  document.querySelector('#btn_add').addEventListener('click', (event) => {
    stampDate.setDate(stampDate.getDate() + 1);
    let dayAfter = formatDate(stampDate);
    document.querySelector('#inp_date').value = dayAfter;
    // formを送信する
    let fm = document.querySelector('#submit_date');
    fm.submit();
  }, false);
</script>
@endsection