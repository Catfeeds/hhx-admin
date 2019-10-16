<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('static/css/hhx.css')}}" rel="stylesheet">
    <title>Hhx周报</title>
</head>
<body>
<div>
    <div class ="daily-title">
        <div class="alert alert-success" role="alert">
            <h4 class="text-muted daily-text"> 日期：</h4>
            <p class="text-muted daily-text">{{$week_again}}-{{date("Y-m-d")}} </p>
            <h4 class="text-success daily-text"> 总结：</h4>
            @foreach($daily_summary as$key=> $summary)
                <p class="text-success daily-text">{{$key+1}}.{{$summary}}</p>
            @endforeach
            <h4 class="text-warning daily-text"> 成长：</h4>
            @foreach($daily_grow_up as$key=> $grow_up)
                <p class="text-warning daily-text">{{$key+1}}.{{$grow_up}}</p>
            @endforeach
        </div>
    </div>
    <div class ="daily-img-list">
        @if(count($daily_Img)>0)
            <div class ="daily-img">
                <p class="text-primary daily-text">图片：</p>
                @foreach($daily_Img as $img)
                    <img src="{{asset('storage/'.$img)}}" class="img-thumbnail">
                @endforeach
            </div>
        @endif
        @if(count($daily_collocation)>0)
            <div class = "daily-img daily-collocation">
                <p class="text-info daily-text">穿搭：</p>
                @foreach($daily_collocation as $collocation)
                    <img src="{{asset('storage/'.$collocation)}}" class="img-thumbnail">
                @endforeach
            </div>
        @endif
    </div>
    @if(count($direction_logs)>0)
        <div class="daily-list">
            <ul class="list-group">
                @foreach($direction_logs as $direction)
                    <li class="list-group-item"><span class="badge">{{$direction->money}}</span>{{$direction->illustration}}</li>
                @endforeach
                    <li class="list-group-item list-group-item-success">合计：<span class="badge">{{$directionSum}}</span></li>
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