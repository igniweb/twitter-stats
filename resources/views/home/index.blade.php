@extends('layout')

@section('main')
<ol class="list">
    <li><a href="{{ route('amcharts') }}">AmCharts</a></li>
    <li><a href="{{ route('google_charts') }}">Google Charts</a></li>
</ol>
@stop
