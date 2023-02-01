@extends('layouts.default')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('/css/app.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/attendance.css') }}" />
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- bootstrap-datepicker -->
<link rel="stylesheet" href="{{ asset('/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker3.standalone.css') }}" />
<script src="{{ asset('/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/bootstrap-datepicker-1.9.0-dist/locales/bootstrap-datepicker.ja.min.js') }}"></script>
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
  <div class="date">
    <input type="text" class="form-control" id="date_sample">
  </div>
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
      <td>{{ $stamp->start_work }}</td>
      <td>{{ $stamp->end_work }}</td>
      <td>00:30:00</td>
      <td>{{ $workTimes[$loop->index] }}</td>
    </tr>
    @endforeach
  </table>
  <div class="pagination">
    {!! $stamps->links('vendor.pagination.bootstrap-4') !!}
  </div>
</div>
@endsection

@section('js')
<script>
  $('#date_sample').datepicker({
    language: 'ja'
  });
</script>
@endsection