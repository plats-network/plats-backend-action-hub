@extends('web.layout')
@section('content')
    <div id="app">
        <home active="{{$active}}" link_cws="{{config('app.link_cws')}}">

        </home>
    </div>
@endsection
