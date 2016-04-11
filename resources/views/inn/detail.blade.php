@extends('layouts.app')

@section('title', '首页')

@section('content')
<div class="inn-detail">
    <div class="inn">
        <a class="inn-captures" href="javascript:;">
            <img src="/media/images/20130910020515619.jpg" alt="">
            <div class="inn-price">
                <sup>￥</sup>100
            </div>
        </a>
    </div>
    <div class="inn-footer">
        <div class="host">
            <a href="/users/123"><img src="/media/images/d807d8e8c1fd73a38c634b336954ca07.png" alt=""></a>
        </div>
        <div class="name"><p>黄冈侗歌师傅吴成龙风家光秀美光</p></div>
        <div class="location">
            <p>中国,贵州,黎平</p>
        </div>
    </div>
    <div class="inn-desc">
        <h3>关于吴成龙的家</h3>
        <p>侗族大哥非物质文化传承人</p>
        <h4>住宿条件</h4>
        <p>客房数：</p>
        <p>可住人数：</p>
        <p>卫生间数：</p>
        <p>浴室：</p>
        <h4>餐饮</h4>
        <p>balabal</p>
        <h4>体验项目</h4>
        <p>balabal</p>
        <h4>交通指南</h4>
        <p>balabal</p>
        <h4>注意事项</h4>
        <p>balabal</p>
    </div>
</div>
<div class="order-btn">
    <a href="/inns/123/order" class="btn btn-primary btn-block">立即预定</a>
</div>
<script>
    API.inns.get({{$id}})
    .then(function(resp) {

    })
    .fail(function(error) {

    });
</script>
@endsection
