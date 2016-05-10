<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>来我家呗 - @yield('title')</title>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    @yield('stylesheet')
</head>
<body @yield('bodyClass')>
    <div class="container">
        @yield('content')
    </div>
    <script src="{{ elixir('js/lib.js') }}"></script>
    <script src="{{ elixir('js/common.js') }}"></script>
    @yield('script')
    <script src="http://s4.cnzz.com/stat.php?id=1259053629&web_id=1259053629" language="JavaScript"></script>
</body>
</html>