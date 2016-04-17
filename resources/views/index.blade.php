@extends('layouts.app')

@section('title', '首页')

@section('content')
    @foreach($inns as $inn)
    <div class="inn">
        <a class="inn-captures" href="/inns/{{ $inn->id }}">
            <img src="http://121.41.8.56/media/images/{{ json_decode($inn->images)[0] }}" alt="{{ $inn->name }}">
            <div class="inn-price">
                <sup>￥</sup>{{ $inn->price }}
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
@endsection
