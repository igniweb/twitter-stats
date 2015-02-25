<html>
<head>
    <meta charset="utf-8">
    <title>Twitter stats</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body>
    <div class="container">
        <h1>Twitter stats</h1>
        <h2>Search {{ $search->q }} <small>{{ $search->from . ' &mdash; ' . $search->to }}</small></h2>
        <pre><?php print_r(json_decode($search->stats, true)); ?></pre>
    </div>
</body>
</html>
