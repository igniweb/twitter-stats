<html>
<head>
    <meta charset="utf-8">
    <title>Twitter stats</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body>
    <div class="container">
        <h1>#EnvoyeSpecial 2015-02-12 - 2015-02-14</h1>
        <h2>Top tweets</h2>
        <ul class="committed">
            @foreach ($committed as $tweet)
                <li title="{{ $tweet['user_account'] }}"><strong>{{ $tweet['commitments'] }}</strong> {{ $tweet['text'] }}</li>
            @endforeach
        </ul>
        <h2>Hashtags</h2>
        <ul class="hashtags">
            @foreach ($hashtags as $hashtag)
                <li><strong>{{ $hashtag->occurences }}</strong> #{{ $hashtag->label }}</li>
            @endforeach
        </ul>
        <h2>Tweets <small>({{ count($tweets) }})</small></h2>
        <ul class="tweets">
            @foreach ($tweets as $tweet)
                <li title="{{ $tweet->user_account }}">{{ $tweet->text }}</li>
            @endforeach
        </ul>
    </div>
</body>
</html>
