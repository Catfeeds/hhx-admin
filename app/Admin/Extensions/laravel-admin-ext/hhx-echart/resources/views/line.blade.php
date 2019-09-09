<div id="chart-{{$chartId}}" style="height:{{$height}};width: 100%;" >加载中....</div>
<script>
$(function () {
    var chartJson = '{!! $chartJson !!}';
    var chartData = JSON.parse(chartJson);
	var myChart_{{$chartId}} = echarts.init(document.getElementById('chart-{{$chartId}}'),null,{renderer: 'canvas'});
	myChart_{{$chartId}}.setOption({
        color: [
            '#ff7f50', '#00fa9a', '#ff00ff', '#32cd32', '#7b68ee',
            '#0A0A0A', '#b8860b', '#cd5c5c', '#ffd700', '#87cefa',
            '#0000CD', '#DC143C', '#A4D3EE', '#6B6B6B'
        ],
		title: {
            show: false,
			text: chartData.title,
		},
        legend: {
            type: 'scroll',
            data:chartData.legend.data,
            width:'60%',
            selected: chartData.legend.selected,
        },

        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
		toolbox: {
            show: true,
            feature: {
                magicType : {show: true, type: ['line','bar']},
            }
		},
        calculable: true,
		xAxis: {
			type: 'category',
			boundaryGap: false,
			data: chartData.xAxisData
		},
        yAxis: [
            {
                name: chartData.yAxisName,
                type: 'value',
                position: 'left'
            }
        ],
		series: chartData.seriesData,
        dataZoom:{
            show:true
        }
	});
});
</script>