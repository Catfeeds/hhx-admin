<div id="chart-{{$chartId}}" style="height:{{$height}};">加载中....</div>
<script>
$(function () {
    var chartJson = '{!! $chartJson !!}';
    var chartData = JSON.parse(chartJson);
	var myChart_{{$chartId}} = echarts.init(document.getElementById('chart-{{$chartId}}'),null,{renderer: 'canvas'});
	myChart_{{$chartId}}.setOption({
		title: {
			text: chartJson.title,
            x: 'left'
		},
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        legend: {
            data:chartData.legend.data,
        },
        xAxis : [
            {
                type : 'category',
                data : chartData.xAxisData
            }
        ],

        yAxis : [
            {
                type : 'value'
            }
        ],
        series: [{
            name: chartData.legend.data[0],
            type: 'bar',
            stack:'sum',
            itemStyle:{
                normal:{
                    label: {
                        show: true,//是否展示
                    },
                    color:'#DF7010'
                }
            },
            data: chartData.seriesData1,
        }, {
            name: chartData.legend.data[1],
            type: 'bar',
            stack:'sum',
            itemStyle:{
                normal:{
                    label: {
                        show: true,//是否展示
                    },
                    color:'#1FBCD2'
                }
            },
            data: chartData.seriesData2,
        }]
	});
});
</script>