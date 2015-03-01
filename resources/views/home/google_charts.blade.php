@extends('layout')

@section('main')
<h2>Search {{ $search->q }} <small>{{ $search->from . ' &mdash; ' . $search->to }}</small></h2>
@stop

@section('scripts')
<script>
    var topUsers = <?php echo json_encode(array_slice($stats['topUsers'], 0, 5)); ?>;
    var topHashtags = <?php echo json_encode(array_slice($stats['topHashtags'], 0, 5)); ?>;
    var topMentions = <?php echo json_encode(array_slice($stats['topMentions'], 0, 5)); ?>;
    var tweetsDistributionPerHour = <?php echo json_encode($stats['tweetsDistributionPerHour']); ?>;
</script>
@stop
