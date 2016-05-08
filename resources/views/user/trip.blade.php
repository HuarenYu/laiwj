@extends('layouts.app')

@section('title', '我的行程')

@section('content')
    @if(count($trips) === 0)
        <div class="message-center">
            <p class="message">暂无行程:)</p>
            <p><a href="/" class="btn btn-primary">立刻去预订</a></p>
        </div>
    @else
        <div class="trips">
        @foreach($trips as $trip)
            <div class="trip">
                <p>预订：{{ $trip->inn->name }}</p>
                <p>入住：@date($trip->start_date) 离开：@date($trip->end_date)</p>
                <p>入住人数：{{ $trip->customer_count }}</p>
                <p>预定天数：{{ $trip->book_count }}</p>
                <p>每人每天花费：￥{{ $trip->per_price }}</p>
                <p>合计：￥{{ $trip->total_price }}</p>
                <p>行程状态：<span class="status">{{ $orderStatus[$trip->status] }}</span></p>
                @if($trip->status == 'created')
                <div class="trip-action">
                    <a href="javascript:;" class="btn btn-small cancel-order" data-id="{{ $trip->id }}">取消</a>
                    <a href="/user/trip/pay/{{ $trip->id }}" class="btn btn-primary btn-small">支付</a>
                </div>
                @endif
                @if($trip->status == 'pay_succeed')
                <div class="trip-action">
                    <a href="tel:{{ $trip->inn->hostPhone }}" class="btn btn-primary btn-small">联系{{ $trip->inn->hostName }}</a>
                </div>
                @endif
            </div>
        @endforeach
        </div>
    @endif
@endsection

@section('script')
<script>
    $('.trip').on('click', '.cancel-order', function(e) {
        $trip = $(e.delegateTarget);
        API.orders.cancel($(this).data('id'))
        .then(function(resp) {
            alert(resp.msg);
            if (resp.status == 'success') {
                $trip.find('.status').text('行程取消');
                $trip.find('.trip-action').remove();
            }
        })
        .fail(function(error) {
            alert('网络错误，请稍后重试');
        });
    });
</script>
@endsection

