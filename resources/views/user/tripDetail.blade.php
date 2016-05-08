@extends('layouts.app')

@section('title', '我的行程')

@section('content')
<div class="trips">
    <div class="trip">
        <p>预订：{{ $trip->inn->name }}</p>
        <p>入住：@date($trip->start_date) 离开：@date($trip->end_date)</p>
        <p>入住人数：{{ $trip->customer_count }}</p>
        <p>预定天数：{{ $trip->book_count }}</p>
        <p>每人每天花费：￥{{ $trip->per_price }}</p>
        <p>合计：￥{{ $trip->total_price }}</p>
        @if($trip->status == 'created')
        <div class="trip-action">
            <a href="javascript:;" class="btn btn-small cancel-order" data-id="{{ $trip->id }}">取消</a>
            <a href="/user/trip/pay/{{ $trip->id }}" class="btn btn-primary btn-small">支付</a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')
<script>
    $('.trip').on('click', '.cancel-order', function(e) {
        $trip = $(e.delegateTarget);
        API.orders.cancel($(this).data('id'))
        .then(function(resp) {
            alert(resp.msg);
            if (resp.status == 'success') {
                $trip.find('.trip-action').remove();
            }
        })
        .fail(function(error) {
            alert('网络错误，请稍后重试');
        });
    });
</script>
@endsection
