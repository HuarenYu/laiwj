@extends('layouts.app')

@section('title', '免费体验报名')

@section('content')
    <div class="form">
        <form id="freeTryForm">
            {{ csrf_field() }}
            <div class="form-group-100">
                <label for="">姓名</label>
                <input name="name" type="text" required>
            </div>
            <div class="form-group-100">
                <label for="">性别</label>
                <select name="gender" id="">
                    <option value=""></option>
                    <option value="男">男</option>
                    <option value="女">女</option>
                </select>
            </div>
            <div class="form-group-100">
                <label for="">职业</label>
                <input name="career" type="text" required>
            </div>
            <div class="form-group-100">
                <label for="">年龄</label>
                <input name="age" type="text" required>
            </div>
            <div class="form-group-100">
                <label for="">联系电话</label>
                <input name="phone" type="text" required>
            </div>
            <div class="form-group-100">
                <label for="">来自哪里?</label>
                <input name="from" type="text" required>
            </div>
            <div class="form-group-100">
                <label for="">什么时候来体验？</label>
                <input name="exp_time" type="text" required>
            </div>
            <div class="form-group-100">
                <label for="">介绍一下你自己</label>
                <textarea name="introduce" cols="" rows="3" required></textarea>
            </div>
            <div class="form-group-100">
                <button class="btn btn-primary">提交</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
<script>
    $('#freeTryForm').on('submit', function (e) {
        e.preventDefault();
        $.post('/user/freeTrip/signup', $(this).serialize())
                .then(function (resp) {
                    alert('报名成功，请等待工作人员的回复');
                    window.location = '/';
                })
                .fail(function (err) {
                    alert(JSON.stringify(err.responseJSON));
                });
    });
</script>
@endsection
