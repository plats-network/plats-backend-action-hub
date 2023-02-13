@extends('admin.layout')
@section('content')
    <div id="app">
        <task-create csrf="{{ csrf_token() }}">
        </task-create>
    </div>
@endsection
