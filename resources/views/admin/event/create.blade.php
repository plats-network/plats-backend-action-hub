@extends('admin.layout')

@section('content')
    <div id="app">
        <event-create csrf="{{ csrf_token() }}" link_cws="{{config('app.link_cws')}}"></event-create>
    </div>
@endsection
