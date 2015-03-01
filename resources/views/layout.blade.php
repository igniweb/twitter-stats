<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Twitter stats</title>
    <link rel="stylesheet" type="text/css" href="/dist/css/styles.min.css">
</head>
<body>
    <div class="container">
        <h1>Twitter stats</h1>
        @yield('main')
    </div>
    <script src="/dist/js/scripts.min.js?t={{ file_get_contents(base_path('resources/assets/.version')) }}"></script>
    @yield('scripts')
</body>
</html>
