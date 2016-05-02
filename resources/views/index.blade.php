@extends('layouts.app')

@section('title', '首页')

@section('content')
    @foreach($inns as $inn)
    <div class="inn">
        <a class="inn-captures" href="/inns/{{ $inn->id }}">
            <img src="//7xqkeq.com1.z0.glb.clouddn.com/{{ json_decode($inn->images)[0] }}?imageView2/1/w/640/h/320/q/100/format/jpg" alt="{{ $inn->name }}">
            <div class="inn-price">
                <sup>￥</sup>{{ $inn->price }}
                <p class="comment">(每人每天住宿+餐饮)</p>
            </div>
        </a>
        <div class="inn-des">
            <p>{{ $inn->name }}</p>
            <a href="/user/{{ $inn->host->id }}" class="inn-host">
                <img src="{{ $inn->host->headimgurl }}" alt="{{ $inn->host->name }}">
            </a>
        </div>
    </div>
    @endforeach
    <div class="load-more">暂无更多</div>
@endsection
