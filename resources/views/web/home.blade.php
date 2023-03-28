@extends('web.layout')
@section('content')
    <div id="app">
        <home active="{{$active}}" link_event="{{config('app.link_event')}}">

        </home>
    </div>
@endsection
