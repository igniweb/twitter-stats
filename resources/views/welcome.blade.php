<html>
<head>
    <meta charset="utf-8">
    <title>Twitter stats</title>
    <!-- <link rel="stylesheet" type="text/css" href="/dist/css/styles.min.css"> -->
</head>
<body>
    <div class="container">
        <h1>Twitter stats</h1>
        <h2>Search {{ $search->q }} <small>{{ $search->from . ' &mdash; ' . $search->to }}</small></h2>
        <div class="row">
            <div class="col">
            </div>
        </div>
        <div class="row">
            <pre><?php print_r(json_decode($search->stats, true)); ?></pre>
        </div>
    </div>
    <script src="/dist/js/scripts.min.js?t={{ file_get_contents(base_path('resources/assets/.version')) }}"></script>
</body>
</html>
