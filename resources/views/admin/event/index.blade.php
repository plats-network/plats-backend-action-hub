@extends('admin.layout')

@section('content')
    <div id="app">
        <event csrf="{{ csrf_token() }}" link_qrc="{{config('app.link_qrc')}}">

        </event>
    </div>
@endsection
