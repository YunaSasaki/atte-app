<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('/css/reset.css') }}" />
  <link rel="stylesheet" href="{{ asset('/css/default.css') }}" />
  @yield('stylesheet')
  <title>Atte</title>
</head>

<body>
  <div class="container">
    <header class="header">
      <div class="wrapper">
        <h1 class="logo">Atte</h1>
        @yield('header')
      </div>
    </header>
    <main class="main">
      @yield('main')
    </main>
    <footer class="footer">
      <small>Atte,inc.</small>
    </footer>
  </div>
</body>

</html>