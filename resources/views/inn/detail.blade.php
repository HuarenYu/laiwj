@extends('layouts.app')

@section('title', $inn->hostName.'的家')

@section('content')
<div class="inn-detail">
    <div class="inn">
        <a class="inn-captures" href="javascript:;">
            <img src="//7xqkeq.com1.z0.glb.clouddn.com/{{ $inn->images[0] }}?imageView2/1/w/800/h/600/q/100/format/jpg" alt="{{ $inn->name }}">
            <div class="inn-price">
                <sup>￥</sup>{{ $inn->price }}
            </div>
        </a>
    </div>
    <div class="inn-footer">
        <div class="host">
            <a href="/users/123"><img src="{{ $inn->host->headimgurl }}" alt="{{ $inn->host->name }}"></a>
        </div>
        <div class="name"><p>{{ $inn->name }}</p></div>
        <div class="location">
            <p>{{ $inn->country }},{{ $inn->province }},{{ $inn->city }},{{ $inn->hostName }}</p>
        </div>
    </div>
    <div class="inn-desc">
        {!! $inn->detail !!}
    </div>
</div>
<div class="inn-albums">
    @for($i = 1; $i < count($inn->images); $i++)
        <div class="album">
        <img src="//7xqkeq.com1.z0.glb.clouddn.com/{{ $inn->images[$i] }}?imageView2/1/w/800/h/600/q/100/format/jpg" alt="images">
        </div>
    @endfor
</div>
<div class="order-btn">
    <!--
    <a href="/inns/{{ $inn->id }}/order" class="btn btn-primary btn-block">立即预定</a>
    -->
    <a href="/user/freeTrip" class="btn btn-primary btn-block">报名免费体验</a>
</div>
@endsection

