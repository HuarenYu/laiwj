@extends('layouts.app')

@section('title', $inn->hostName.'的家')

@section('stylesheet')
<link rel="stylesheet" href="/unslider/css/unslider.css">
<link rel="stylesheet" href="/unslider/css/unslider-dots.css">
@endsection

@section('bodyClass')
class="home-detail"
@endsection

@section('content')
<div class="inn-detail">
    <div class="inn">
        <a class="inn-captures" href="javascript:;">
            <div class="img-slider">
                <ul>
                    @foreach($inn->images as $image)
                    <li><img src="//7xqkeq.com1.z0.glb.clouddn.com/{{ $image }}?imageView2/1/w/460/h/320/q/100/format/jpg" alt="{{ $inn->name }}"></li>
                    @endforeach
                </ul>
            </div>
            <div class="inn-price">
                <sup>￥</sup>{{ $inn->price }}
                <p class="comment">(每人每天住宿+餐饮)</p>
            </div>
        </a>
    </div>
    <div class="inn-footer">
        <div class="host">
            <a href="javascript:;"><img src="{{ $inn->host->headimgurl }}" alt="{{ $inn->host->name }}"></a>
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
@include('_partials.footer')
<div class="order-btn">
    <a href="/inns/{{ $inn->id }}/order" class="btn btn-primary btn-block">立即预定</a>
</div>
@endsection

@section('script')
<script src="/unslider/js/unslider-min.js"></script>
<script>
    $(function() {
        $('.img-slider').unslider({
            autoplay: true,
            arrows: false
        });
    });
</script>
@endsection

