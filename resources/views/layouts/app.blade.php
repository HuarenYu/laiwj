<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>来我家呗 - @yield('title')</title>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    @yield('stylesheet')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    <script src="http://121.41.8.56{{ elixir('js/lib.js') }}"></script>
    <script src="{{ elixir('js/common.js') }}"></script>
    @yield('script')
</body>
</html>