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
                <p>每人每天花费：{{ $trip->per_price }}</p>
                <p>预订日期：@date($trip->start_date)-@date($trip->end_date)</p>
            </div>
        @endforeach
        </div>
    @endif
@endsection
