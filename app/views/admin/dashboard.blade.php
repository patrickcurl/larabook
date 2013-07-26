@extends('layouts.master')
@section('content')


Welcome to the dashboard.
@foreach ($orders as $order)
{{ $order->total_amount }}
@endforeach
@stop