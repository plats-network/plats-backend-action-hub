@extends('web.layout')
@section('content')
    <div id="app">
        <detail class="container" detail_id="{{$id}}" key_local="{{$key}}">
        </detail>
    </div>
@endsection
