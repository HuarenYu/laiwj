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
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-77531311-1', 'auto');
        ga('send', 'pageview');
    </script>
</body>
</html>