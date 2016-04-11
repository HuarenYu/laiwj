@extends('layouts.app')

@section('title', '首页')

@section('content')
    
<div class="inn">
    <a class="inn-captures" href="/inns/123">
        <img src="/media/images/20130910020515619.jpg" alt="">
        <div class="inn-price">
            <sup>￥</sup>100
        </div>
    </a>
    <div class="inn-des">
        <p>黄冈侗歌师傅吴成龙风家光秀美光</p>
        <a href="/user/id" class="inn-host">
            <img src="/media/images/d807d8e8c1fd73a38c634b336954ca07.png" alt="">
        </a>
    </div>
</div>

<script>
    API.inns.getAll()
    .then(function(data) {
        console.log(data);
    })
    .fail(function(error) {
        console.log(error);
    });
</script>
@endsection
