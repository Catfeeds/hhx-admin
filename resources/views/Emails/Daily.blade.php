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
        <div class="alert alert-success" role="alert">
            <p class="text-muted daily-text"> 日期：{{$yesterDate}} </p>
            <p class="text-primary daily-text"> 星期：周{{$week}} </p>
            <p class="text-success daily-text"> 总结：{{$daily->summary}} </p>
            <p class="text-warning daily-text"> 成长：{{$daily->grow_up}} </p>
        </div>
    </div>
    <div class ="daily-img-list">
        <div class ="daily-img">
            <p class="text-primary daily-text">今日图片：</p>
            <img src="{{asset('storage/'.$daily->Img)}}" class="img-thumbnail">
        </div>
        <div class = "daily-img daily-collocation">
            <p class="text-info daily-text">今日穿搭：</p>
            <img src="{{asset('storage/'.$daily->collocation)}}" class="img-thumbnail">
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
    @if(count($weibos) >0)
        <div class ="daily-title">
                <div class ="daily-img">
                    <h4 class="text-danger daily-text">WeiBo</h4>
                    @foreach($weibos as $key=> $weibo)
                        <p class="text-muted daily-text">{{$key+1}}</p>
                        <p class="text-primary daily-text">{{$weibo['screen_name']}}</p>
                        <p class="text-success daily-text">{!! $weibo['text'] !!}</p>
                        <p class="text-warning daily-text">{{$weibo['weibo_created_at']}}</p>
                        @if($weibo['pic_num']>1 && count($weibo['pics'])>0)
                            @foreach($weibo['pics'] as $pic)
                                <img src="{{asset('storage/'.$pic)}}" style="width:20%;height: 20%" class="img-rounded">
                            @endforeach
                        @endif
                        @if($weibo['pic_num'] ==1)
                            <img src="{{asset('storage/'.$weibo['thumbnail_pic'])}}" class="img-rounded">
                        @endif
                    @endforeach
                </div>
        </div>
    @endif
</div>

</body>
</html>