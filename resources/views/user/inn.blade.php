@extends('layouts.app')

@section('title', '我的家')

@section('content')

    @if (count($inn) == 0)
        <div class="message-center">
            <p class="message">发布你家的资料请远方的客人来玩吧:)</p>
            <p><button id="addInn" type="button" class="btn btn-primary">去发布</button></p>
        </div>
    @else

    @endif
    <div class="inn-form">
        <form action="/inns/" id="createInnForm">
            <div class="form">
                <div class="form-group-100">
                    <label for="">你家的名字</label>
                    <input name="name" type="text" placeholder="取一个突出你家特色的名字">
                </div>
                <div class="form-group-100">
                    <label for="">每天每人花费</label>
                    <input name="price" type="text">
                </div>
                <div class="form-group-100">
                    <label for="">你家的照片</label>
                    <input name="image" type="file">
                </div>
                <div class="form-group-100">
                    <label for="">详细介绍一下吧</label>
                    <textarea id="mytextarea" name="detail">
                        <h1>关于我的家</h1>
                        <p>写一段介绍吧...</p>
                        <h2>住宿条件</h2>
                        <p>客房:</p>
                        <p>可住人数:</p>
                        <p>卫生间数:</p>
                        <p>浴室条件:</p>
                        <p>空调:</p>
                        <p>洗衣机:</p>
                        <h2>餐饮</h2>
                        <p>早餐时间:</p>
                        <p>中餐时间:</p>
                        <p>晚餐时间:</p>
                        <p>提供的特色美食:</p>
                        <h2>体验项目</h2>
                        <p>你可带客人体验哪些项目</p>
                        <h2>交通指南</h2>
                        <p>客人如何到你家</p>
                        <h2>注意事项</h2>
                        <p>客人需要注意哪些</p>
                    </textarea>
                </div>
                <div class="form-group-100 submit">
                    <button type="submit" class="btn btn-primary btn-block">发布</button>
                </div>
            </div>
        </form>
    </div>
    <script src="/tinymce/tinymce.min.js"></script>
    <script src="/tinymce/zh_CN.js"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea',
            toolbar: false,
            height : 400,
        });
        $('#addInn').on('click', function (e) {
            $('.message-center').remove();
            $('.inn-form').show();
        });
        $('#createInnForm').on('submit', function (e) {

        })
    </script>
@endsection
