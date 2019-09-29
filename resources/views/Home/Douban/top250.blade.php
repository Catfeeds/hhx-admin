<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Top250</title>
    <!-- Bootstrap -->
{{--    <link href="{{asset('static/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('static/css/hhx.css')}}" rel="stylesheet">
    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>

    <![endif]-->
</head>
<body>

<div class="min-div">
    <div class="page-header">
        <h1>DouBan-Top250 <small>Subtext for header</small></h1>
    </div>
    @foreach($data as $da)
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">{{$da->c_title.$da->w_title.$da->year}}</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-default">排名:No.{{$da->no}}</li>
                    <li class="list-group-item list-group-item-default">评分:{{$da->rating_num}}</li>
                    <li class="list-group-item list-group-item-default">{{$da->inq}}</li>
                    <li class="list-group-item list-group-item-default">{{$da->comment_num}}</li>
                    <li class="list-group-item list-group-item-default">导演:{{$da->director}}</li>
                    <li class="list-group-item list-group-item-default">主演:{{$da->actor}}</li>
                    <li class="list-group-item list-group-item-default">类型:{{$da->type}}</li>
                    <li class="list-group-item list-group-item-default">时长:{{$da->time_long}}</li>
                    <li class="list-group-item list-group-item-default">上映日期:{{$da->release_date}}</li>
                    <li class="list-group-item list-group-item-default">简介:{{$da->intro}}</li>
                </ul>
                @if(!empty($da->pan_url))
                    <button type="button"  class="btn btn-s btn-info" data-toggle="popover" data-content="CODE:{{$da->pan_code}}" title="URL:{{$da->pan_url}}">Url</button>
                @endif
            </div>
        </div>
        @endforeach
       <div class="page-div"> {!! $data->render() !!} </div>
</div>

<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
</body>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>
</html>