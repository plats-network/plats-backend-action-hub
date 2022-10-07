@extends('admin.layout')
@section('content')
    <x-admin::top_page :title="trans('admin.task.create_page')"/>
    @include('admin.task.form')
@endsection
