@extends('layouts.app')

@section('title', $inn->hostName.'的家')

@section('content')
<div class="inn-detail">
    <div class="inn">
        <a class="inn-captures" href="javascript:;">
            <img src="http://121.41.8.56/media/images/{{ json_decode($inn->images)[0] }}" alt="{{ $inn->name }}">
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
<div class="order-btn">
    <a href="/inns/{{ $inn->id }}/order" class="btn btn-primary btn-block">立即预定</a>
</div>
@endsection

