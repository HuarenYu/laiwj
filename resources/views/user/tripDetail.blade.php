@extends('layouts.app')

@section('title', '我的行程')

@section('content')
<div class="trips">
    <div class="trip">
        <p>预订：{{ $trip->inn->name }}</p>
        <p>入住：@date($trip->start_date) 离开：@date($trip->end_date)</p>
        <p>预定天数：{{ $trip->book_count }}</p>
        <p>入住人数：{{ $trip->customer_count }}</p>
        <p>每人每天花费：￥{{ $trip->per_price }}</p>
        <p>合计：￥{{ $trip->total_price }}</p>
        <div class="trip-action">
            <a href="#" class="btn btn-small">取消</a>
            <a href="/user/trip/paytest/{{ $trip->id }}" class="btn btn-primary btn-small">支付</a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
@endsection
