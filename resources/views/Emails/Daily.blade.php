<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('static/css/hhx.css')}}" rel="stylesheet">
    <title>日报</title>
</head>
<body>
<div>
    <div class ="daily-title">
        <div class="alert alert-success" role="alert">日期：{{$yesterDate}}</div>
        <div class="alert alert-info" role="alert">周{{$week}}</div>
        <div class="alert alert-warning" role="alert">总结：{{$daily->summary}}</div>
        <div class="alert alert-danger" role="alert">成长：{{$daily->grow_up}}</div>
    </div>
    <div class ="daily-img-list">
        <div class ="daily-img">
            <p class="text-primary daily-text">今日图片：</p>
            <img src="{{storage_path($daily->Img)}}" class="img-thumbnail">
        </div>
        <div class = "daily-img daily-collocation">
            <p class="text-info daily-text">今日穿搭：</p>
            <img src="{{asset($daily->collocation)}}" class="img-thumbnail">
        </div>
    </div>
    @if(count($direction_logs)>0)
        <div class="daily-list">
            <ul class="list-group">
                @foreach($direction_logs as $direction)
                    <li class="list-group-item"><span class="badge">{{$direction->money}}</span>{{$direction->illustration}}</li>
                @endforeach
                    <li class="list-group-item list-group-item-success">合计：<span class="badge">{{$daily->money}}</span></li>
            </ul>
        </div>
    @endif
    @if(count($interest_logs)>0)
        <div class="daily-list">
            <ul class="list-group">
                @foreach($interest_logs as $interest)
                    <li class="list-group-item">{{$interest->illustration}}</li>
                @endforeach
                <li class="list-group-item list-group-item-success">共：{{count($interest_logs)}}</li>
            </ul>
        </div>
    @endif
</div>

</body>
</html>