@extends('layouts.app')

@section('title', '首页')

@section('content')
<div class="order-form">
    <form action="/inns/">
        <div class="form">
            <div class="form-group-50">
                <label for="">入住</label>
                <input type="text">
            </div>
            <div class="form-group-50">
                <label for="">离开</label>
                <input type="text">
            </div>
            <div class="form-group-100">
                <label for="">入住人数</label>
                <input type="text">
            </div>
            <div class="form-group-100">
                <label for="">联系人</label>
                <input type="text">
            </div>
            <div class="form-group-100">
                <label for="">联系电话</label>
                <input type="text">
            </div>
            <div class="form-group-100 submit">
                <button class="btn btn-primary btn-block">提交订单</button>
            </div>
        </div>
    </form>
</div>
<script>
</script>
@endsection
