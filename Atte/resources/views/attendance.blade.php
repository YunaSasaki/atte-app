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
    <!-- <label class="date-edit"><input type="date" id="stamp_date" name="stamp_date" value="{{ $stamp_date }}" /></label> -->
    <input type="date" id="inp3" style="width:0px; border-width:0px;" name="stamp_date" value="{{ $stamp_date }}">
    <input type="button" id="btn3" value="{{ $stamp_date }}">
  </form>
  <table class="display">
    <thead>
      <tr>
        <th>名前</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
        <th>勤務日</th>
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
        <td>{{ $stamp->stamp_date }}</td>
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
  var date = new Date();
  var yyyy = date.getFullYear();
  var mm = ("0" + (date.getMonth() + 1)).slice(-2);
  var dd = ("0" + date.getDate()).slice(-2);
  document.getElementById("today").value = yyyy + '-' + mm + '-' + dd;
</script>
<script>
  let flg = false;
  // ボタンがクリックされたときの処理
  document.querySelector('#btn3').addEventListener('click', (event) => {
    document.querySelector('#inp3').showPicker();
  }, false);

  // 日付が選択されたときの処理
  document.querySelector('#inp3').addEventListener('change', (event) => {
    document.querySelector('#btn3').value = event.target.value;
    // formを送信する
    var fm = document.getElementById("submit_date");
    fm.submit();
  }, false);

  // var picker = document.getElementById('picker');
  // picker.addEventListener('click', function() {
  //   var flg = "on";
  // }, false);

  // var stampDate = document.getElementById('stamp_date');
  // stampDate.addEventListener('blur', function() {
  //   var flg = null;
  // }, false);

  // stampDate.addEventListener('change', function() {
  //   if (flg == "on") {
  //     var fm = document.getElementById("submit_date");
  //     fm.submit();
  //     var flg = null;
  //   }
  // }, false);

  // formを送信する
  // function submitDate() {
  //   var fm = document.getElementById("submit_date");
  //   fm.submit();
  // }
</script>
@endsection