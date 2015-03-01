@extends('layout')

@section('main')
<h2>Search {{ $search->q }} <small>{{ $search->from . ' &mdash; ' . $search->to }}</small></h2>
<div class="row">
    <div class="col-md-4">
        <div id="top_users" style="width: 100%; height: 400px;"></div>
    </div>
    <div class="col-md-4">
        <div id="top_hashtags" style="width: 100%; height:400px;"></div>
    </div>
    <div class="col-md-4">
        <div id="top_mentions" style="width: 100%; height: 400px;"></div>
    </div>
</div>
<div class="row">
    <div id="tweets_distribution_per_hour" style="width: 100%; height: 400px;"></div>
</div>
<div class="row">
    <pre><?php print_r($stats['committedTweets']); ?></pre>
</div>
@stop

@section('scripts')
<script>
    AmCharts.ready(function () {
        var chart;

        var topUsers = <?php echo json_encode(array_slice($stats['topUsers'], 0, 5)); ?>;
        var topHashtags = <?php echo json_encode(array_slice($stats['topHashtags'], 0, 5)); ?>;
        var topMentions = <?php echo json_encode(array_slice($stats['topMentions'], 0, 5)); ?>;
        var tweetsDistributionPerHour = <?php echo json_encode($stats['tweetsDistributionPerHour']); ?>;

        chart = new AmCharts.AmFunnelChart();
        chart.rotate = true;
        chart.titleField = 'name';
        chart.balloon.fixedPosition = true;
        chart.marginRight = 210;
        chart.marginLeft = 15;
        chart.labelPosition = "right";
        chart.funnelAlpha = 0.9;
        chart.valueField = "occurences";
        chart.startX = -500;
        chart.dataProvider = topUsers;
        chart.startAlpha = 0;
        chart.write('top_users');

        chart = new AmCharts.AmPieChart();
        chart.addTitle('Top hashtags', 16);
        chart.dataProvider = topHashtags;
        chart.titleField = 'label';
        chart.valueField = 'occurences';
        chart.sequencedAnimation = true;
        chart.startEffect = 'elastic';
        chart.innerRadius = '30%';
        chart.startDuration = 2;
        chart.labelRadius = 15;
        chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart.depth3D = 10;
        chart.angle = 15;                        
        chart.write('top_hashtags');

        chart = new AmCharts.AmSerialChart();
        chart.dataProvider = topMentions;
        chart.categoryField = 'name';
        chart.rotate = true;
        chart.depth3D = 20;
        chart.angle = 30;
        var categoryAxis = chart.categoryAxis;
        categoryAxis.gridPosition = 'start';
        categoryAxis.axisColor = '#dadada';
        categoryAxis.fillAlpha = 1;
        categoryAxis.gridAlpha = 0;
        categoryAxis.fillColor = '#fafafa';
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.axisColor = '#dadada';
        valueAxis.title = 'Occurences';
        valueAxis.gridAlpha = 0.1;
        chart.addValueAxis(valueAxis);
        var graph = new AmCharts.AmGraph();
        graph.title = 'Top user mentions';
        graph.valueField = 'occurences';
        graph.type = 'column';
        graph.balloonText = 'Occurences of [[category]]:[[value]]';
        graph.lineAlpha = 0;
        graph.fillColors = '#bf1c25';
        graph.fillAlphas = 1;
        chart.addGraph(graph);
        chart.creditsPosition = 'top-right';
        chart.write('top_mentions');

        chart = new AmCharts.AmSerialChart();
        chart.dataProvider = tweetsDistributionPerHour;
        chart.categoryField = 'day_hour';
        chart.startDuration = 1;
        var categoryAxis = chart.categoryAxis;
        categoryAxis.labelRotation = 90;
        categoryAxis.gridPosition = 'start';
        var graph = new AmCharts.AmGraph();
        graph.valueField = 'occurences';
        graph.balloonText = '[[category]]: <b>[[value]]</b>';
        graph.type = 'column';
        graph.lineAlpha = 0;
        graph.fillAlphas = 0.8;
        chart.addGraph(graph);
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = false;
        chartCursor.categoryBalloonEnabled = false;
        chart.addChartCursor(chartCursor);
        chart.creditsPosition = 'top-right';
        chart.write('tweets_distribution_per_hour');
    });
</script>
@stop
