@extends('admin.layout')

@section('content')
    <x-admin::top_page :title="trans('admin.task.edit_page')"/>
    @include('admin.company.form')
@endsection
