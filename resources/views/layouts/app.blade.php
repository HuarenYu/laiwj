<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>来我家呗 - @yield('title')</title>
    <link rel="stylesheet" href="/css/app.css">
    @yield('stylesheet')
    <script src="http://121.41.8.56/js/lib.js"></script>
    <script src="/js/common.js"></script>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>