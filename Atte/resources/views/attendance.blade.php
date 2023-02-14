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
        <td hidden>{{ $stamp->stamp_date }}</td>
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
  // id="today"にデフォルトで今日の日付を設定する
  var now = new Date();
  var yyyy = now.getFullYear();
  var mm = ("0" + (now.getMonth() + 1)).slice(-2);
  var dd = ("0" + now.getDate()).slice(-2);
  document.querySelector('#today').value = yyyy + '-' + mm + '-' + dd;
</script>
<script>
  // カレンダーボタンがクリックされたときの処理
  document.querySelector('#btn_picker').addEventListener('click', (event) => {
    document.querySelector('#inp_date').showPicker();
  }, false);

  // 日付が選択されたときの処理
  document.querySelector('#inp_date').addEventListener('change', (event) => {
    document.querySelector('#btn_picker').value = event.target.value;
    // formを送信する
    var fm = document.getElementById("submit_date");
    fm.submit();
  }, false);
</script>
<script>
  // 一日前
  document.querySelector('#btn_sub').addEventListener('click', (event) => {
    var date = new Date('{{ $stamp_date }}');
    date.setDate(date.getDate() - 1);
    var yyyy = date.getFullYear();
    var mm = ("0" + (date.getMonth() + 1)).slice(-2);
    var dd = ("0" + date.getDate()).slice(-2);
    document.querySelector('#inp_date').value = yyyy + '-' + mm + '-' + dd;
    // formを送信する
    var fm = document.getElementById("submit_date");
    fm.submit();
  }, false);
</script>
<script>
  // 一日後
  document.querySelector('#btn_add').addEventListener('click', (event) => {
    var date = new Date('{{ $stamp_date }}');
    date.setDate(date.getDate() + 1);
    var yyyy = date.getFullYear();
    var mm = ("0" + (date.getMonth() + 1)).slice(-2);
    var dd = ("0" + date.getDate()).slice(-2);
    document.querySelector('#inp_date').value = yyyy + '-' + mm + '-' + dd;
    // formを送信する
    var fm = document.getElementById("submit_date");
    fm.submit();
  }, false);
</script>
@endsection