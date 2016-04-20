@extends('layouts.app')

@section('title', '我的家')

@section('stylesheet')
    <link rel="stylesheet" href="http://121.41.8.56/medium-editor/css/medium-editor.min.css">
    <link rel="stylesheet" href="http://121.41.8.56/medium-editor/css/themes/default.min.css">
@endsection

@section('content')

    @if(empty($inn))
        <div class="message-center">
            <p class="message">发布你家的资料，请远方的客人来玩吧:)</p>
            <p><button id="addInn" type="button" class="btn btn-primary">去发布</button></p>
        </div>
        <div class="inn-form hidden">
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
                    <div class="form-group-100" id="imageContainer">
                        <label for="">你家的照片</label>
                        <button id="image" class="btn" type="button">添加照片</button>
                    </div>
                    <div class="form-group-100">
                        <label for="">详细介绍一下吧</label>
                        <div id="detail" class="form-input inn-form-detail">
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
                        </div>
                    </div>
                    <div class="form-group-100 submit">
                        <button type="submit" class="btn btn-primary btn-block">发布</button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="inn-form visible">
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
                    <div class="form-group-100" id="imageContainer">
                        <label for="">你家的照片</label>
                        <button id="image" class="btn" type="button">更换照片</button>
                    </div>
                    <div class="form-group-100">
                        <label for="">详细介绍一下吧</label>
                        <div id="detail" class="form-input inn-form-detail">{!! $inn->detail !!}</div>
                    </div>
                    <div class="form-group-100 submit">
                        <button type="submit" class="btn btn-primary btn-block">保存修改</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection
@section('script')
    <script src="http://121.41.8.56/plupload/plupload.full.min.js"></script>
    <script src="http://121.41.8.56/qiniu/qiniu.min.js"></script>
    <script src="http://121.41.8.56/medium-editor/js/medium-editor.min.js"></script>
    <script>
        var inn = {};
        var editor = new MediumEditor('#detail');
        $('#addInn').on('click', function (e) {
            $('.message-center').remove();
            $('.inn-form').css({visibility: 'visible'});
        });
        $('#createInnForm').on('submit', function (e) {
            e.preventDefault();
            inn._token = $('input[name=_token]').val();
            inn.name = $('input[name=name]').val();
            inn.hostName = $('input[name=hostName]').val();
            inn.hostPhone = $('input[name=hostPhone]').val();
            inn.price = $('input[name=price]').val();
            inn.detail = $('#detail').html();
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
                /*
                if (!inn.image || inn.image === '') {
                    alert('你的图片不能为空');
                    return;
                }
                */
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

        var uploader = Qiniu.uploader({
            runtimes: 'html5,html4',      // 上传模式,依次退化
            browse_button: 'image',         // 上传选择的点选按钮，**必需**
            // 在初始化时，uptoken, uptoken_url, uptoken_func 三个参数中必须有一个被设置
            // 切如果提供了多个，其优先级为 uptoken > uptoken_url > uptoken_func
            // 其中 uptoken 是直接提供上传凭证，uptoken_url 是提供了获取上传凭证的地址，如果需要定制获取 uptoken 的过程则可以设置 uptoken_func
            // uptoken : '<Your upload token>', // uptoken 是上传凭证，由其他程序生成
            uptoken_url: '/file/uploadToken',         // Ajax 请求 uptoken 的 Url，**强烈建议设置**（服务端提供）
            // uptoken_func: function(file){    // 在需要获取 uptoken 时，该方法会被调用
            //    // do something
            //    return uptoken;
            // },
            get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
            // downtoken_url: '/downtoken',
            // Ajax请求downToken的Url，私有空间时使用,JS-SDK 将向该地址POST文件的key和domain,服务端返回的JSON必须包含`url`字段，`url`值为该文件的下载地址
            unique_names: true,                 // 默认 false，key 为文件名。若开启该选项，JS-SDK 会为每个文件自动生成key（文件名）
            // save_key: true,                  // 默认 false。若在服务端生成 uptoken 的上传策略中指定了 `sava_key`，则开启，SDK在前端将不对key进行任何处理
            domain: '7xqkeq.com1.z0.glb.clouddn.com',     // bucket 域名，下载资源时用到，**必需**
            container: 'imageContainer',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
            max_file_size: '5mb',               // 最大文件体积限制
            flash_swf_url: '/plupload/Moxie.swf',  //引入 flash,相对路径
            max_retries: 3,                     // 上传失败最大重试次数
            dragdrop: false,                     // 开启可拖曳上传
            drop_element: 'imageContainer',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
            chunk_size: '4mb',                  // 分块上传时，每块的体积
            auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
            //x_vars : {
            //    自定义变量，参考http://developer.qiniu.com/docs/v6/api/overview/up/response/vars.html
            //    'time' : function(up,file) {
            //        var time = (new Date()).getTime();
                      // do something with 'time'
            //        return time;
            //    },
            //    'size' : function(up,file) {
            //        var size = file.size;
                      // do something with 'size'
            //        return size;
            //    }
            //},
            init: {
                'FilesAdded': function(up, files) {
                    plupload.each(files, function(file) {
                        // 文件添加进队列后,处理相关的事情
                    });
                },
                'BeforeUpload': function(up, file) {
                    // 每个文件上传前,处理相关的事情
                },
                'UploadProgress': function(up, file) {
                    // 每个文件上传时,处理相关的事情
                       
                },
                'FileUploaded': function(up, file, info) {
                    // 每个文件上传成功后,处理相关的事情
                    // 其中 info 是文件上传成功后，服务端返回的json，形式如
                    // {
                    //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                    //    "key": "gogopher.jpg"
                    //  }
                    // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                    var domain = up.getOption('domain');
                    var res = JSON.parse(info);
                    //var sourceLink = domain + '/' + res.key; //获取上传成功后的文件的Url
                    inn.image = res.key;
                },
                'Error': function(up, err, errTip) {
                    //上传出错时,处理相关的事情
                    console.log(err);
                },
                'UploadComplete': function() {
                    //队列文件处理完毕后,处理相关的事情
                },
                'Key': function(up, file) {
                    // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                    // 该配置必须要在 unique_names: false , save_key: false 时才生效
                    var key = "";
                    // do something with key here
                    return key
                }
            }
        });
    </script>
@endsection
