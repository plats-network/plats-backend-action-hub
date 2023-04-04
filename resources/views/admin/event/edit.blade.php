@extends('admin.layout')

@section('content')
    <div id="app">
        <event-edit task_id="{{$task_id}}" csrf="{{ csrf_token() }}" link_cws="{{config('app.link_cws')}}"></event-edit>
    </div>
@endsection
