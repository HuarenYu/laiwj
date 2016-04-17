@extends('layouts.app')

@section('title', '我的家')

@section('content')

    @if(empty($inn))
        <div class="message-center">
            <p class="message">发布你家的资料，请远方的客人来玩吧:)</p>
            <p><button id="addInn" type="button" class="btn btn-primary">去发布</button></p>
        </div>
        <div class="inn-form">
            <form id="createInnForm" data-action="create">
                {{ csrf_field() }}
                <div class="form">
                    <div class="form-group-100">
                        <label for="">你家的名字</label>
                        <input name="name" type="text" placeholder="想一个突出你家特色的名字吧" required>
                    </div>
                    <div class="form-group-100">
                        <label for="">你的姓名</label>
                        <input name="hostName" type="text" required>
                    </div>
                    <div class="form-group-100">
                        <label for="">你的联系电话</label>
                        <input name="hostPhone" type="text" required>
                    </div>
                    <div class="form-group-100">
                        <label for="">每天每人花费</label>
                        <input name="price" type="text" required>
                    </div>
                    <div class="form-group-100">
                        <label for="">你家的照片</label>
                        <input name="image" type="file" required>
                    </div>
                    <div class="form-group-100">
                        <label for="">详细介绍一下吧</label>
                        <textarea id="detail" name="detail">
                            <h1>关于我的家</h1>
                            <p>写一段介绍吧...</p>
                            <h2>住宿条件</h2>
                            <p>客房数：</p>
                            <p>可住人数：</p>
                            <p>卫生间数：</p>
                            <p>浴室条件：</p>
                            <p>空调：</p>
                            <p>洗衣机：</p>
                            <p>电冰箱：</p>
                            <p>网络：</p>
                            <h2>餐饮</h2>
                            <p>早餐时间：</p>
                            <p>中餐时间：</p>
                            <p>晚餐时间：</p>
                            <p>提供的特色美食：</p>
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
    @else
        <div class="inn-form" style="display: block">
            <form id="createInnForm" data-action="update">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $inn->id }}">
                <div class="form">
                    <div class="form-group-100">
                        <label for="">你家的名字</label>
                        <input name="name" type="text" value="{{ $inn->name }}" placeholder="想一个突出你家特色的名字吧" required>
                    </div>
                    <div class="form-group-100">
                        <label for="">你的姓名</label>
                        <input name="hostName" type="text" value="{{ $inn->hostName }}" required>
                    </div>
                    <div class="form-group-100">
                        <label for="">你的联系电话</label>
                        <input name="hostPhone" type="text" value="{{ $inn->hostPhone }}" required>
                    </div>
                    <div class="form-group-100">
                        <label for="">每天每人花费</label>
                        <input name="price" type="text" value="{{ $inn->price }}" required>
                    </div>
                    <div class="form-group-100">
                        <label for="">你家的照片</label>
                        <input name="image" type="file">
                    </div>
                    <div class="form-group-100">
                        <label for="">详细介绍一下吧</label>
                        <textarea id="detail" name="detail">
                            {{ $inn->detail }}
                        </textarea>
                    </div>
                    <div class="form-group-100 submit">
                        <button type="submit" class="btn btn-primary btn-block">保存修改</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
    
    <script src="http://121.41.8.56/tinymce/tinymce.min.js"></script>
    <script src="http://121.41.8.56/tinymce/zh_CN.js"></script>
    <script>
        tinymce.init({
            selector: '#detail',
            toolbar: false,
            height : 400,
        });
        var inn = {};
        $('#addInn').on('click', function (e) {
            $('.message-center').remove();
            $('.inn-form').show();
        });
        $('#createInnForm').on('submit', function (e) {
            e.preventDefault();
            inn._token = $('input[name=_token]').val();
            inn.name = $('input[name=name]').val();
            inn.hostName = $('input[name=hostName]').val();
            inn.hostPhone = $('input[name=hostPhone]').val();
            inn.price = $('input[name=price]').val();
            inn.detail = tinymce.activeEditor.getContent({format: 'raw'});
            if (!inn.name || inn.name === '') {
                alert('家的名字不能为空');
                return;
            }
            if (!inn.hostName || inn.hostName === '') {
                alert('你的名字不能为空');
                return;
            }
            if (!inn.hostPhone || inn.hostPhone === '') {
                alert('你的联系电话不能为空');
                return;
            }
            if (!inn.price || inn.price === '') {
                alert('每天每人花费不能为空');
                return;
            }
            if (!inn.detail || inn.detail === '') {
                alert('你家的详情不能为空');
                return;
            }
            var action = $(this).data('action');
            if (action === 'create') {
                if (!inn.image || inn.image === '') {
                    alert('你的图片不能为空');
                    return;
                }
                API.inns.add(inn).
                then(function (resp) {
                    alert('添加成功');
                    window.location = '/inns/' + resp.id;
                }).fail(function (err) {
                    alert(JSON.stringify(err.responseJSON));
                });
            }
            if (action === 'update') {
                inn.id = $('input[name=id]').val();
                API.inns.update(inn).
                then(function (resp) {
                    alert('修改成功');
                    window.location = '/inns/' + resp.id;
                }).fail(function (err) {
                    alert(JSON.stringify(err.responseJSON));
                });
            }
        });

        $('input[name=image]').on('change', function (e) {
            if (!this.files[0]) return;
            var fd = new FormData();
            fd.append('image', this.files[0]);
            $.ajax({
                url: 'http://121.41.8.56/file/images',
                method: 'POST',
                data: fd,
                processData: false,
                contentType: false,
            }).then(function (resp) {
                inn.image = resp.image;
            }).fail(function (error) {
                alert('网络错误,请稍后重试!');
            });
        });
    </script>
@endsection
