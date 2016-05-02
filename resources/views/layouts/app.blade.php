<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>来我家呗 - @yield('title')</title>
    <link rel="stylesheet" href="http://121.41.8.56{{ elixir('css/app.css') }}">
    @yield('stylesheet')
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    <footer class="footer">
        <div class="left">
            <img src="/weixin_qrcode.jpg" alt="微信关注：laiwojiabei">
            <p>长按识别二维码加关注</p>
            <p>微信公众号：laiwojiabei</p>
        </div>
    </footer>
    <script src="http://121.41.8.56{{ elixir('js/lib.js') }}"></script>
    <script src="http://121.41.8.56{{ elixir('js/common.js') }}"></script>
    @yield('script')
</body>
</html>