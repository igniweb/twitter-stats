<?php $stats = json_decode($search->stats, true); ?>
<html>
<head>
    <meta charset="utf-8">
    <title>Twitter stats</title>
    <link rel="stylesheet" type="text/css" href="/dist/css/styles.min.css">
</head>
<body>
    <div class="container">
        <h1>Twitter stats</h1>
        <h2>Search {{ $search->q }} <small>{{ $search->from . ' &mdash; ' . $search->to }}</small></h2>
        <div class="row">
            <div class="col">
                <div id="top_users" style="width: 500px; height: 300px;"></div>
            </div>
            <div class="col">
                <div id="top_hashtags" style="width:600px; height:400px;"></div>
            </div>
            <div class="col">
                <div id="top_mentions" style="width: 500px; height: 600px;"></div>
            </div>
        </div>
        <div class="row">
            <div id="tweets_distribution_per_hour" style="width: 100%; height: 400px;"></div>
        </div>
        <div class="row">
            <pre><?php print_r($stats['committedTweets']); ?></pre>
        </div>
    </div>
    <script src="/dist/js/scripts.min.js?t={{ file_get_contents(base_path('resources/assets/.version')) }}"></script>
    <script>
        AmCharts.ready(function () {
            var chart;

            var topUsers = <?php echo json_encode($stats['topUsers']); ?>;
            var topHashtags = <?php echo json_encode($stats['topHashtags']); ?>;
            var topMentions = <?php echo json_encode($stats['topMentions']); ?>;
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
</body>
</html>
