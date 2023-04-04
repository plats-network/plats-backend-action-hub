@extends('admin.layout')

@section('content')
    <div id="app">
        <event-preview task_id="{{$task_id}}" link_cws="{{config('app.link_cws')}}"></event-preview>
    </div>
@endsection
